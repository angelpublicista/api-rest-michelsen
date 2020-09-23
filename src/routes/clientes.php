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
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});



/*===========================================
************** TABLA CLIENTES ****************
=============================================*/


//GET Todos los clientes
$app->get('/api/clientes/', function(Request $request, Response $response){
    $sql = utf8_encode("SELECT * FROM cliente");
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        
        if($resultado){
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode("No existen clientes en la base de datos");
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


//GET Recuperar cliente por ID
$app->get('/api/clientes/{id}/', function(Request $request, Response $response){
    $idCliente = $request->getAttribute('id');
    $sql = "SELECT * FROM cliente WHERE IdCln = $idCliente";
    
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado){
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
        } else {
            echo json_encode("No existen clientes en la base de datos con este ID");
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


/*===========================================
************** TABLA CRÉDITOS ****************
=============================================*/

//GET Todos los créditos
$app->get('/api/creditos/', function(Request $request, Response $response){
    $sql = "SELECT * FROM credito";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado){
            $creditos = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($creditos);
        } else {
           return null;
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
    $sql = "SELECT * FROM credito WHERE IdCln = $idCliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado){
            $creditos = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($creditos);
        } else {
            return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/json')
            ->write('Something went wrong!');
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

/*===========================================
************** TABLA PLANES ****************
=============================================*/

//GET Recuperar cuotas por crédito
$app->get('/api/creditos/cuotas/{numCrd}/', function(Request $request, Response $response){
    $NumCrd = $request->getAttribute('numCrd');
    $sql = "SELECT * FROM planes WHERE NumCrd = $NumCrd";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado){
            $cuotas = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($cuotas);
        } else {
            return null;
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});