<?php

namespace Controllers;

use Exception;
use Model\Detalle;
use MVC\Router;

class DetalleController
{
    public static function estadistica(Router $router)
    {
        // $router->render('clientes/estadistica', []);
        if(!isset($_SESSION['auth_user'])){
            $router->render('login/index', []);
        }else{
            $router->render('clientes/estadistica', []);
        }
    }

    public static function detalleComprasAPI()
    {

        $sql = "SELECT c.cliente_nombre AS nombre,
        COUNT(*) AS cantidad_compras
 FROM clientes c
 LEFT JOIN ventas v ON c.cliente_id = v.venta_cliente
 LEFT JOIN detalle_ventas dv ON v.venta_id = dv.detalle_venta
 WHERE c.cliente_situacion = '1'
   AND dv.detalle_situacion = '1'
   AND v.venta_situacion = '1'
 GROUP BY c.cliente_id, nombre
 ORDER BY cantidad_compras DESC ";

        try {

            $productos = Detalle::fetchArray($sql);

            echo json_encode($productos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}
