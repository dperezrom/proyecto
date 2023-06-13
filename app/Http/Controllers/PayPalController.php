<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Factura;
use App\Models\Linea;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function processTransaction(Request $request)
    {
        $importeTotal = 0;
        $direccionId = request()->query('direccion');
        if (!in_array($direccionId, array_column(Auth::user()->direcciones->toArray(), 'id')) || empty(session()->get('cart_item'))) {
            return redirect()->route('carritos.ver-carrito')->with('error', $response['message'] ?? 'Algo salió mal.');
        }
        session()->put('temp_direccion', Direccion::find($direccionId));

        foreach (session()->get('cart_item') as $item) {
            $producto = Producto::find($item['productoId']);
            if ($producto->stock < $item['cantidad']) {
                return redirect()->route('carritos.ver-carrito')
                    ->with('error', $response['message'] ?? 'Insuficiente stock de ' . $producto->denominacion . '.');
            }
            $importeTotal += $item['total'];
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => round($importeTotal,2)
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->route('carritos.ver-carrito')->with('error', $response['message'] ?? 'Algo salió mal.');
        } else {
            return redirect()->route('carritos.ver-carrito')->with('error', $response['message'] ?? 'Algo salió mal.');
        }
    }

    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $direccion = session()->get('temp_direccion');
            //Creamos la factura
            $factura = new Factura();
            $factura->numero = $this->generarCodigoFactura();
            $factura->nombre = $direccion->nombre;
            $factura->user_id = Auth::id();
            $factura->fecha = now();
            $factura->calle = $direccion->calle;
            $factura->ciudad = $direccion->ciudad;
            $factura->instruccion = $direccion->instruccion;
            $factura->save();

            foreach (session()->get('cart_item') as $item) {
                //Creamos las líneas de productos
                $linea = new Linea();
                $linea->factura_id = $factura->id;
                $linea->producto_id = $item['productoId'];
                $linea->cantidad = $item['cantidad'];
                $linea->precio = $item['precio'];
                $linea->iva = $item['iva'];
                $linea->descuento = $item['descuento'];
                $linea->save();

                //Consumimos el stock
                $producto = Producto::find($item['productoId']);
                $producto->stock -= $item['cantidad'];
                $producto->stock = $producto->stock <= 0 ? 0 : $producto->stock;
                $producto->save();
            }

            session()->forget('temp_direccion');
            session()->forget('cart_item');
            session()->forget('cart_item_cantidad_total');

            return redirect()->route('carritos.ver-carrito')->with('success', 'Transacción completada');
        } else {
            return redirect()->route('carritos.ver-carrito')->with('error', $response['message'] ?? 'Algo salió mal.');
        }
    }

    public function cancelTransaction(Request $request)
    {
        return redirect()->route('carritos.ver-carrito')->with('error', 'Has cancelado la transacción.');
    }

    private function generarCodigoFactura(){
        $anyo = date("Y");
        $resultado = DB::table('facturas')->select(DB::raw('substring(numero,7)::INT +1 AS secuencia'))->whereRaw('substring(numero,2,4)::INT = ?', [$anyo])->orderBy('numero', 'DESC')->first();
        return empty($resultado->secuencia) ? 'F' . $anyo . '-1' : 'F' . $anyo .'-'. $resultado->secuencia;
    }
}
