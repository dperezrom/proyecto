<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritosController extends Controller
{
    // Ver carrito
    public function ver_carrito()
    {
        session()->put('cart_item_total', $this->comprobarCantidadTotal());

        //session()->forget('cart_item');
        return view('carritos.ver-carrito');
    }

    private function comprobarStock(Producto $producto, $cantidadSolicitada)
    {
        if ($producto->stock <= $cantidadSolicitada) {
            return $producto->stock;
        }
        return $cantidadSolicitada;
    }

    private function comprobarCantidadTotal()
    {
        $carrito = session()->get('cart_item');
        if(empty($carrito)){
            return 0;
        }
        return array_sum(array_column($carrito, 'cantidad'));
    }

    public function actualizar_carrito(Request $request)
    {
        $modo = $request->modo;
        $productoId = $request->producto_id;
        $cantidad = $request->cantidad;
        $carrito = session()->get('cart_item');
        $producto = Producto::find($productoId);

        if (!is_numeric($productoId) || empty($producto) || !in_array($modo, ['item', 'cantidad']) || !is_numeric($cantidad) || $cantidad <= 0) {
            return redirect()->route('carritos.ver-carrito')->with('error', 'No se ha podido actualizar el carrito.');
        }

        //Nuevo item
        if (is_numeric($productoId) && $modo === 'item' && !isset($carrito[$productoId])) {

            $item = [
                'productoId' => $productoId,
                'imagen' => $producto->imagen,
                'denominacion' => $producto->denominacion,
                'cantidad' => $this->comprobarStock($producto, $cantidad),
                'precio' => $producto->precio,
                'iva' => $producto->impuesto->porcentaje,
                'descuento' => $producto->descuento,
                'total' => $cantidad * ($producto->precio * ((100 - $producto->descuento) / 100)),
                'stock' => $producto->stock,
            ];

            $carrito[$productoId] = $item;
            session()->put('cart_item', $carrito);
            return redirect()->route('carritos.ver-carrito')->with('success', 'Carrito actualizado');
        }

        //Modificar cantidad item
        if (is_numeric($productoId) && (($modo === 'cantidad') || ($modo === 'item' && isset($carrito[$productoId])))) {
            if ($modo === 'cantidad') {
                $carrito[$productoId]['cantidad'] = $this->comprobarStock($producto, $cantidad);
            }
            if ($modo === 'item') {
                $carrito[$productoId]['cantidad'] = $this->comprobarStock($producto, ($carrito[$productoId]['cantidad'] += $cantidad));
            }
            $carrito[$productoId]['stock'] = $producto->stock;
            $carrito[$productoId]['precio'] = $producto->precio;
            $carrito[$productoId]['total'] = $carrito[$productoId]['cantidad'] * ($carrito[$productoId]['precio'] * ((100 - $carrito[$productoId]['descuento']) / 100));
            session()->put('cart_item', $carrito);
            return redirect()->route('carritos.ver-carrito')->with('success', 'Carrito actualizado');
        }

        return redirect()->route('carritos.ver-carrito');
    }

    public function borrar_item_carrito(Request $request)
    {
        $modo = $request->modo;
        $productoId = $request->producto_id;
        $carrito = session()->get('cart_item');

        if (is_numeric($productoId) && isset($carrito[$productoId]) && $modo === 'item') {
            unset($carrito[$productoId]);
            session()->put('cart_item', $carrito);
            return redirect()->route('carritos.ver-carrito')->with('success', 'Producto eliminado del carrito.');
        }

        if (isset($carrito) && $modo === 'all') {
            session()->forget('cart_item');
            return redirect()->route('carritos.ver-carrito')->with('success', 'Se ha vaciado el carrito.');
        }

        return redirect()->route('carritos.ver-carrito');
    }
}
