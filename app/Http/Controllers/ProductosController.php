<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Impuesto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    const RUTA_IMG_PRODUCTOS = 'images/productos';

    // Index
    public function index()
    {
        // Campos buscador
        $campos = [
            'denominacion',
            'descripcion',
            'categoria_id',
            'activo',
            'precio',
            'precio_signo',
            'impuesto_id',
            'stock',
            'stock_signo',
            'descuento',
            'descuento_signo',
        ];

        foreach ($campos as $campo) {
            ${$campo} = request()->query($campo);
        }

        // Orden
        $ordenes = ['denominacion', 'descripcion', 'precio', 'categoria_id'];
        $orden = request()->query('orden') ?: 'denominacion';
        abort_unless(in_array($orden, $ordenes), 404);
        $torden = request()->query('torden') ?: 'ASC';

        $productos = Producto::orderBy($orden, $torden);

        // Filtrado
        $campos_estandar = ['denominacion', 'descripcion', 'categoria_id', 'activo', 'impuesto_id'];
        $campos_numericos = ['precio', 'stock', 'descuento'];

        foreach ($campos_estandar as $campo) {
            if ((request()->query($campo)) !== null) {
                $productos->where($campo, 'ilike', '%' . request()->query($campo) . '%');
            }
        }

        foreach ($campos_numericos as $campo) {
            if ((request()->query($campo)) !== null) {
                if (is_numeric(request()->query($campo))) {
                    $productos->where($campo, request()->query($campo . '_signo') ?: '=', request()->query($campo));
                }
            }
        }

        // Paginador
        $paginador = $productos->paginate(10);
        $paginador->appends(compact(
            'orden',
            'torden',
            'denominacion',
            'descripcion',
            'categoria_id',
            'activo',
            'precio',
            'precio_signo',
            'impuesto_id',
            'stock',
            'stock_signo',
            'descuento',
            'descuento_signo',

        ));

        return view('admin.productos.index', [
            'productos' => $paginador,
            'categorias' => Categoria::all(),
            'impuestos' => Impuesto::all(),
            'campos' => $campos,
        ]);
    }

    // Validación
    public function validar()
    {
        $validados = request()->validate([
            'denominacion' => 'required|string|max:100',
            'descripcion' => 'required|max:255',
            'precio' => 'required|numeric|regex:/^[\d]{0,4}(\.[\d]{1,2})?$/',
            'impuesto_id' => 'required|integer',
            'stock' => 'required|integer|between:0,99999',
            'descuento' => 'required|integer|between:0,100',
            'activo' => 'in:t,f',
            'categoria_id' => 'required|integer',
            'imagen' => 'mimes:jpeg,png',
        ], [
            'denominacion.required' => 'El campo «Denominación» es obligatorio',
            'denominacion.max' => 'El campo «Denominación» solo permite hasta 100 caracteres',
            'descripcion.required' => 'El campo «Descripción» es obligatorio',
            'descripcion.max' => 'El campo «Descripción» solo permite hasta 255 caracteres',
            'precio.required' => 'El campo «Precio» es obligatorio',
            'precio.numeric' => 'El campo «Precio» debe ser numérico',
            'precio.regex' => 'El campo «Precio» solo puede contener 4 enteros y 2 decimales',
            'impuesto_id.required' => 'El campo «IVA» es obligatorio',
            'impuesto_id.integer' => 'El campo «IVA» debe ser un número entero',
            'stock.required' => 'El campo «Stock» es obligatorio',
            'stock.integer' => 'El campo «Stock» debe ser un número entero',
            'stock.between' => 'El campo «Stock» tiene que ser de 0 a 999999',
            'descuento.required' => 'El campo «Descuento» es obligatorio',
            'descuento.integer' => 'El campo «Descuento» debe ser un número entero',
            'descuento.between' => 'El campo «Descuento» tiene que ser de 0 a 100',
            'activo.in' => 'El campo «Activo» contiene un valor incorrecto',
            'categoria_id.required' => 'El campo «Categoría» es obligatorio',
            'categoria_id.integer' => 'El campo «Categoría» debe ser un número entero',
            'imagen.mimes' => 'Solo se aceptan imágenes jpeg y png',
        ]);

        return $validados;
    }

    // Crear producto
    public function create()
    {
        $producto = new Producto();

        return view('admin.productos.create', [
            'producto' => $producto,
            'categorias' => Categoria::all(),
            'impuestos' => Impuesto::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validados = $this->validar();

        $producto = new Producto();
        $producto->denominacion = ucfirst(trim($validados['denominacion']));
        $producto->descripcion = ucfirst(trim($validados['descripcion']));
        $producto->precio = $validados['precio'];
        $producto->impuesto_id = $validados['impuesto_id'];
        $producto->stock = $validados['stock'];
        $producto->activo = !empty($validados['activo']) ? 't' : 'f';
        $producto->descuento = $validados['descuento'];
        $producto->categoria_id = $validados['categoria_id'];
        $producto['imagen'] = $this->insert_directory_image($request->file('imagen')); //New image
        $producto->save();

        return redirect()->route('admin.productos')->with('success', 'Producto creado con éxito.');
    }

    // Editar producto
    public function edit(Producto $producto)
    {
        return view('admin.productos.edit', [
            'producto' => $producto,
            'categorias' => Categoria::all(),
            'impuestos' => Impuesto::all(),
        ]);
    }

    public function update(Request $request, Producto $producto)
    {
        $validados = $this->validar();
        $producto->denominacion = ucfirst(trim($validados['denominacion']));
        $producto->descripcion = ucfirst(trim($validados['descripcion']));
        $producto->precio = $validados['precio'];
        $producto->impuesto_id = $validados['impuesto_id'];
        $producto->stock = $validados['stock'];
        $producto->activo = !empty($validados['activo']) ? 't' : 'f';
        $producto->descuento = $validados['descuento'];
        $producto->categoria_id = $validados['categoria_id'];

        // Añadir imagen por primera vez o sustituir imagen nueva
        if ($request->file('imagen')) {
            $this->delete_directory_image($producto->imagen);
            $producto['imagen'] = $this->insert_directory_image($request->file('imagen'));
        }

        // No subir imagen y borrar imagen guardada
        if (!$request->file('imagen') && $request->get('eliminarimg') == 't') {
            $this->delete_directory_image($producto->imagen);
            $producto['imagen'] = null;
        }

        $producto->save();

        return redirect()->route('admin.productos')->with('success', 'Producto actualizado');
    }

    private function insert_directory_image($file)
    {
        if ($file) {
            do {
                $filename = date('YmdHisu') . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $url = self::RUTA_IMG_PRODUCTOS . '/' . $filename;

            } while (file_exists($url) && is_file($url));

            $file->move(public_path(self::RUTA_IMG_PRODUCTOS), $filename);
            return $filename;
        }
        return null;
    }

    private function delete_directory_image($imagen)
    {
        if ($imagen) {
            $url = self::RUTA_IMG_PRODUCTOS . '/' . $imagen;
            if (file_exists($url) && is_file($url)) {
                unlink($url);
            }
        }
    }

    // Borrar producto

    public function destroy(Producto $producto)
    {
        if ($producto->lineas->isNotEmpty()) {
            return redirect()->route('admin.productos')->with('error', 'El producto contiene lineas de detalle.');

        } else if ($producto->valoraciones->isNotEmpty()) {
            return redirect()->route('admin.productos')->with('error', 'El producto contiene valoraciones.');

        } else {
            //Borrar imagen del disco
            $url = self::RUTA_IMG_PRODUCTOS . '/' . $producto->imagen;
            ($producto->imagen) ? unlink($url) : '';

            //Borra el producto completo
            $producto->delete();
        }
        return back()->with('success', 'Producto eliminado con éxito.');
    }

    // Mostrar
    public function show(Producto $producto)
    {
        $valoraciones = array_column($producto->valoraciones->toArray(), 'puntuacion');
        $totalValoraciones = count($valoraciones);
        $valoracionMedia = $totalValoraciones ? (array_sum($valoraciones) / $totalValoraciones) : 0;
        $agrupacionValoraciones = array_count_values($valoraciones);

        $porcentajeValoraciones = array();
        for ($i = 5; $i >= 1; $i--) {
            $porcentajeValoraciones[$i] = array_key_exists($i, $agrupacionValoraciones) ? round(((float)$agrupacionValoraciones[$i] * 100) / $totalValoraciones, 0) : 0;
        }

        return view('admin.productos.show', [
            'producto' => $producto,
            'valoracionMedia' => number_format($valoracionMedia, 1),
            'totalValoraciones' => $totalValoraciones,
            'porcentajeValoraciones' => $porcentajeValoraciones,
        ]);
    }

    // Ver Catálogo
    public function ver_catalogo()
    {
        $categorias = Categoria::all()->sortBy('nombre');
        $productos = Producto::where('activo', '=', 't');

        // Filtro precio mínimo
        $precio_min = request()->query('precio_min');
        if ($precio_min && is_numeric($precio_min)) {
            $productos->whereRaw('(precio:: FLOAT * ((100 - descuento:: FLOAT) / 100)) >= ?', [$precio_min]);
        }
        // Filtro precio máximo
        $precio_max = request()->query('precio_max');
        if ($precio_max && is_numeric($precio_max)) {
            $productos->whereRaw('(precio:: FLOAT * ((100 - descuento:: FLOAT) / 100)) <= ?', [$precio_max]);
        }

        // Filtro categorías
        $categoria_seleccionadas = request()->query('categoria_seleccionadas');
        if ($categoria_seleccionadas && empty(preg_grep("/\D/", $categoria_seleccionadas))) {
            $productos->whereIn('categoria_id', $categoria_seleccionadas);
        } else {
            $categoria_seleccionadas = [];
        }

        // Filtro valoraciones
        $stars = request()->query('stars');
        if ($stars && is_numeric($stars)) {
            $productos->whereRaw('productos.id IN (SELECT producto_id FROM valoraciones GROUP BY producto_id HAVING AVG(puntuacion) >= ?)', [$stars]);
        }

        // Filtro nombre
        if ($producto = request()->query('producto')) {
            $productos->where('productos.denominacion', 'ilike', "%$producto%");
        }

        $precio_orden = in_array(request()->query('precio_orden'), ['asc', 'desc'])
            ? request()->query('precio_orden')
            : 'asc';

        $productos = $productos->orderBy('precio', $precio_orden);

        $paginador = $productos->paginate(12);
        $paginador->appends(compact(
            'precio_orden',
            'precio_min',
            'precio_max',
            'categoria_seleccionadas',
            'stars',
            'producto',
        ));

        return view('index', [
            'productos' => $paginador,
            'categorias' => $categorias,
            'categoria_seleccionadas' => $categoria_seleccionadas,
        ]);
    }

    public function ver_producto(Producto $producto)
    {
        $puntuaciones = array_column($producto->valoraciones->toArray(), 'puntuacion');
        $totalValoraciones = count($puntuaciones);
        $valoracionMedia = $totalValoraciones ? (array_sum($puntuaciones) / $totalValoraciones) : 0;
        $agrupacionValoraciones = array_count_values($puntuaciones);

        $porcentajeValoraciones = array();
        for ($i = 5; $i >= 1; $i--) {
            $porcentajeValoraciones[$i] = array_key_exists($i, $agrupacionValoraciones) ? round(((float)$agrupacionValoraciones[$i] * 100) / $totalValoraciones, 0) : 0;
        }

        // Valoraciones del producto
        $valoraciones = $producto->valoraciones();
        $orden = in_array(request()->query('orden'), ['asc', 'desc'])
            ? request()->query('orden') : 'asc';

        $valoraciones = $valoraciones->orderBy('created_at', $orden);
        $valoraciones = $valoraciones->paginate(10);
        $valoraciones->appends(compact(
            'orden',
        ));

        return view('productos.ver-producto', [
            'producto' => $producto,
            'valoracionMedia' => number_format($valoracionMedia, 1),
            'totalValoraciones' => $totalValoraciones,
            'porcentajeValoraciones' => $porcentajeValoraciones,
            'valoraciones' => $valoraciones,
        ]);
    }
}
