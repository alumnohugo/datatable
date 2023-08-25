<?php

namespace Controllers;

use Exception;
use Model\Detalle;
use MVC\Router;

class DetalleController
{
    public static function estadistica(Router $router)
    {
        $router->render('clientes/estadistica', []);
    }

    public static function detalleComprasAPI()
    {

        $sql = "SELECT
        c.cliente_nombre AS cliente,
        p.producto_nombre AS producto,
        SUM(dv.detalle_cantidad) AS cantidad
    FROM
        clientes c
    INNER JOIN
        ventas v ON c.cliente_id = v.venta_cliente
    INNER JOIN
        detalle_ventas dv ON v.venta_id = dv.detalle_venta
    INNER JOIN
        productos p ON dv.detalle_producto = p.producto_id
    WHERE
        dv.detalle_situacion = '1'
        AND v.venta_situacion = '1'
    GROUP BY
        c.cliente_id, c.cliente_nombre, p.producto_id, p.producto_nombre
    ORDER BY
        c.cliente_nombre, p.producto_nombre ";

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
