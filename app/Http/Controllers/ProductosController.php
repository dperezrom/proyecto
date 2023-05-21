<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

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
            'iva',
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
        $campos_estandar = ['denominacion', 'descripcion', 'categoria_id', 'activo', 'iva'];
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
            'iva',
            'stock',
            'stock_signo',
            'descuento',
            'descuento_signo',

        ));

        return view('admin.productos.index', [
            'productos' => $paginador,
            'categorias' => Categoria::all(),
            'campos' => $campos,
        ]);
    }

    // Validación
    public function validar()
    {
        $validados = request()->validate([
            'denominacion' => 'required|string|max:30',
            'descripcion' => 'required|max:255',
            'precio' => 'required|numeric|regex:/^[\d]{0,4}(\.[\d]{1,2})?$/',
            'iva' => 'required|integer|between:0,100',
            'stock' => 'required|integer|between:0,99999',
            'descuento' => 'required|integer|between:0,100',
            'activo' => 'in:t,f',
            'categoria_id' => 'required|integer',
            'imagen' => 'mimes:jpeg,png',
        ], [
            'denominacion.required' => 'El campo «Denominación» es obligatorio',
            'denominacion.max' => 'El campo «Denominación» solo permite hasta 30 caracteres',
            'descripcion.required' => 'El campo «Descripción» es obligatorio',
            'descripcion.max' => 'El campo «Descripción» solo permite hasta 255 caracteres',
            'precio.required' => 'El campo «Precio» es obligatorio',
            'precio.numeric' => 'El campo «Precio» debe ser numérico',
            'precio.regex' => 'El campo «Precio» solo puede contener 4 enteros y 2 decimales',
            'iva.required' => 'El campo «IVA» es obligatorio',
            'iva.integer' => 'El campo «IVA» debe ser entero',
            'iva.between' => 'El campo «IVA» tiene que ser de 0 a 100',
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
        ]);
    }

    public function store(Request $request)
    {
        $validados = $this->validar();

        $producto = new Producto();
        $producto->denominacion = ucfirst(trim($validados['denominacion']));
        $producto->descripcion = ucfirst(trim($validados['descripcion']));
        $producto->precio = $validados['precio'];
        $producto->iva = $validados['iva'];
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
        $categorias = Categoria::all();
        return view('admin.productos.edit', ['producto' => $producto, 'categorias' => $categorias]);
    }

    public function update(Request $request, Producto $producto)
    {
        $validados = $this->validar();
        $producto->denominacion = ucfirst(trim($validados['denominacion']));
        $producto->descripcion = ucfirst(trim($validados['descripcion']));
        $producto->precio = $validados['precio'];
        $producto->iva = $validados['iva'];
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
        if($file){
            do{
                $filename = date('YmdHisu') .'_'. str_replace(' ', '_',$file->getClientOriginalName());
                $url = self::RUTA_IMG_PRODUCTOS . '/' . $filename;

            } while(file_exists($url) && is_file($url));

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
        //Borrar imagen del disco
        $url = self::RUTA_IMG_PRODUCTOS . '/' . $producto->imagen;
        ($producto->imagen) ? unlink($url) : '';

        //Borra el producto completo
        $producto->delete();

        return back()->with('success', 'Producto eliminado con éxito.');
    }

    // Mostrar
    public function show(Producto $producto)
    {
        return view('admin.productos.show', ['producto' => $producto,]);
    }
}
