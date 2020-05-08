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
            //var_dump($clientes);
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
    $sql = "SELECT * FROM test_michelsen.cliente WHERE IdCln = $idCliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
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

//POST Crear nuevo cliente
$app->post('/api/clientes/nuevo/', function(Request $request, Response $response){
    $nombre = $request->getParam('nombre');
    $prApellido = $request->getParam('prApellido');
    $sgApellido = $request->getParam('sgApellido');
    $email = $request->getParam('email');
    $telRes = $request->getParam('telRes');
    $celRes = $request->getParam('celRes');
    
    $sql = "INSERT INTO test_michelsen.cliente (PrApellidoCln, SgApellidoCln, NomCln, emailCln, TelResidenciaCln, CelularCln) VALUES (:prApellido, :sgApellido, :nombre, :email, :telRes, :celRes)";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':prApellido', $prApellido);
        $resultado->bindParam(':sgApellido', $sgApellido);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':email', $email);
        $resultado->bindParam(':telRes', $telRes);
        $resultado->bindParam(':celRes', $celRes);

        $resultado->execute();

        echo json_encode("Nuevo cliente guardado");

        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


//PUT modificar cliente
$app->put('/api/clientes/modificar/{id}/', function(Request $request, Response $response){
    $id_cliente = $request->getAttribute('id');
    $nombre = $request->getParam('nombre');
    $prApellido = $request->getParam('prApellido');
    $sgApellido = $request->getParam('sgApellido');
    $email = $request->getParam('email');
    $telRes = $request->getParam('telRes');
    $celRes = $request->getParam('celRes');
    
    $sql = "UPDATE test_michelsen.cliente SET
        PrApellidoCln = :prApellido,
        SgApellidoCln = :sgApellido,
        NomCln        = :nombre,
        emailCln      = :email,
        TelResidenciaCln = :telRes,
        CelularCln    = :celRes
        WHERE IdCln = $id_cliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':prApellido', $prApellido);
        $resultado->bindParam(':sgApellido', $sgApellido);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':email', $email);
        $resultado->bindParam(':telRes', $telRes);
        $resultado->bindParam(':celRes', $celRes);

        $resultado->execute();

        echo json_encode("Cliente modificado");

        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


//DELETE borrar cliente
$app->delete('/api/clientes/delete/{id}/', function(Request $request, Response $response){
    $id_cliente = $request->getAttribute('id');
    
    $sql = "DELETE FROM test_michelsen.cliente WHERE IdCln = $id_cliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->prepare($sql);
        $resultado->execute();

        if($resultado->rowCount() > 0){
            echo json_encode("Cliente eliminado");
        } else {
            echo json_encode("No existe cliente con ese ID");
        }

        

        
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


//GET Login usuario
$app->get('/api/clientes/login/{email}/{document}/', function(Request $request, Response $response){
    $emailCliente = $request->getAttribute('email');
    $docuCliente = $request->getAttribute('document');

    $sql = "SELECT * FROM test_michelsen.cliente WHERE emailCln = $emailCliente AND DocuCln = $docuCliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
        } else {
            return null;
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        return null;
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


/*===========================================
************** TABLA CRÉDITOS ****************
=============================================*/

//GET Todos los créditos
$app->get('/api/creditos/', function(Request $request, Response $response){
    $sql = "SELECT * FROM test_michelsen.credito";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
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
    $sql = "SELECT * FROM test_michelsen.credito WHERE IdCln = $idCliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
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
    $sql = "SELECT * FROM test_michelsen.planes WHERE NumCrd = $NumCrd";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
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