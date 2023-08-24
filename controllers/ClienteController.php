<?php

namespace Controllers;
use Exception;
use Model\Cliente;
use MVC\Router;

class ClienteController{
    public static function index(Router $router) {
        $router->render('clientes/datatable', []);
// ================hasta aqui se puede ver la tabla sin ejecutarse acciones         
    
    }

    public static function guardarApi(){
     
        try {
            $cliente = new Cliente($_POST);
            $resultado = $cliente->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

   
    public static function buscarApi()
    {
        // $armas = arma::all();
        $cliente_nombre = $_GET['cliente_nombre'];
        $cliente_nit = $_GET['cliente_nit'];
       

        $sql = "SELECT * FROM clientes where cliente_situaciion = 1 ";
        if ($cliente_nombre != '') {
            $sql .= " and cliente_nombre like '%$cliente_nombre%' ";
        }
        
        
        try {
            
            $armas = Arma::fetchArray($sql);
            header('Content-Type: application/json');

            echo json_encode($armas);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function modificarApi(){
     
        try {
            $arma = new Arma($_POST);
            // $resultado = $arma->crear();

            $resultado = $arma->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function eliminarApi(){
     
        try {
            $arma_id = $_POST['arma_id'];
            $arma = Arma::find($arma_id);
            $arma->arma_situacion = 0;
            $resultado = $arma->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro eliminado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

}
 
?>