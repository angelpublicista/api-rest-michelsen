<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application / json; charset = utf-8')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

//GET Todos los créditos
$app->get('/api/creditos/', function(Request $request, Response $response){
    $sql = "SELECT * FROM test_michelsen.credito";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
        } else {
            echo json_encode("No existen créditos en la base de datos");
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


//GET Recuperar credito por IDCliente
$app->get('/api/creditos/{idCl}/', function(Request $request, Response $response){
    $idCliente = $request->getAttribute('idCl');
    $sql = "SELECT * FROM test_michelsen.credito WHERE IdCln = $idCliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
        } else {
            echo json_encode("No existen créditos para este cliente");
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});