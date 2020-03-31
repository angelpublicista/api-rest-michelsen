<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

//GET Todos los clientes
$app->get('/api/clientes', function(Request $request, Response $response){
    $sql = "SELECT * FROM test_michelsen.cliente";
    try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
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
$app->get('/api/clientes/{id}', function(Request $request, Response $response){
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
$app->post('/api/clientes/nuevo', function(Request $request, Response $response){
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
$app->put('/api/clientes/modificar/{id}', function(Request $request, Response $response){
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
$app->delete('/api/clientes/delete/{id}', function(Request $request, Response $response){
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