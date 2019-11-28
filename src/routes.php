<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");


        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);


    });
    $app->post('/login/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        $conexao = $container->get('pdo');
        $params = $request->getParsedBody();
        $senha = md5($params['senha']);
        $sql = 'SELECT * FROM vendedor WHERE nome = "'.$params['nome'].'" AND "'.$senha.'"';
        $resultSet = $conexao->query($sql);
        if (count($resultSet)==1){
            $_SESSION['login']['ehLogado'] = true;
            $_SESSION['login']['nome'] = $resultSet->nome;
            return $response->withRedirect('/home/');
            
        }
        else {
            $_SESSION['login']['ehLogado'] = false;
            return $response->withRedirect('/login/fail');
        }
        
        return $container->get('renderer')->render($response, 'index.phtml', $args);

    });
    $app->get('/home/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        $conexao = $container->get('pdo');
        $sql = 'SELECT * FROM carro where status = 0';
        $resultSet = $conexao->query($sql);
        $args['carros'] = $resultSet;

        // Render index view
        return $container->get('renderer')->render($response, 'home.phtml', $args);


    });


    $app->get('/cadastro/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
 




        // Render index view
        return $container->get('renderer')->render($response, 'cadastro.phtml', $args);


    });
    
    $app->get('/adicionarVeiculo/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
 




        // Render index view
        return $container->get('renderer')->render($response, 'cadastroVeiculo.phtml', $args);


    });
     
    $app->get('/editarVeiculo/[{idcarro}]', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');

         $sql = 'SELECT * FROM carro where idcarro = "'.$args['idcarro'].'"';
         $resultSet = $conexao->query($sql);
         $args['carroEditar'] = $resultSet;
         
        return $container->get('renderer')->render($response, 'editarVeiculo.phtml', $args);
       
        
   
    });
    $app->post('/veiculoEditado/', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');

        $params = $request->getParsedBody();
        
        $resultSet = $conexao->query('UPDATE carro SET modelo = "' . $params['modelo'] . '",  marca= "' . $params['marca'] . '", ano = "' . $params['ano'] . '" WHERE idcarro = ' . $params['idcarro'] . ';');
        return $response->withRedirect('/home/');

        return $container->get('renderer')->render($response, 'editarVeiculo.phtml', $args);
       
        
   
    });


    $app->POST('/cadastroVendedor/', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');
        
        $params = $request->getParsedBody();
        $senha = md5($params['senha']);
        $sql = 'INSERT INTO vendedor VALUES("", "'.$params['nome'].'","'.$senha.'")';
        $resultSet = $conexao->query($sql);

        return $response->withRedirect('/');
        // Render index view
        

    });


    
    $app->POST('/cadastroVeiculo/', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');
        
        $params = $request->getParsedBody();

        $sql = 'INSERT INTO carro(idcarro,modelo,marca,ano) VALUES("","'.$params['modelo'].'","'.$params['marca'].'","'.$params['ano'].'")';
        $resultSet = $conexao->query($sql);

        return $response->withRedirect('/home/');
        // Render index view
        

    });
    $app->get('/apagarcarro/[{idcarro}]', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');
    
        $sql = 'DELETE FROM carro WHERE idcarro = "'.$args['idcarro'].'";';
         $resultSet = $conexao->query($sql);
       
         return $response->withRedirect('/home/');
   
    });

    $app->get('/venderVeiculo/', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');

         $sql = 'SELECT * FROM carro where status=0';
         $resultSet = $conexao->query($sql);
         $args['venderCarro'] = $resultSet;

         $sql2 = 'SELECT * FROM comprador';
         $resultSet2 = $conexao->query($sql2);
         $args['compradores'] = $resultSet2;
         
         
        return $container->get('renderer')->render($response, 'venderVeiculo.phtml', $args);
       
        
   
    });
    $app->post('/veiculoVendido/', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');
        $status = 1;
        $params = $request->getParsedBody();
        
        $resultSet = $conexao->query('UPDATE carro SET idcomprador = "' . $params['idcomprador'] . '" WHERE idcomprador = ' . $params['idcomprador'] . ';');
        $resultSet = $conexao->query('UPDATE carro SET status= "' . $status . '" WHERE idcarro = ' . $params['idcarro'] . ';');

        return $response->withRedirect('/home/');

        return $container->get('renderer')->render($response, 'editarVeiculo.phtml', $args);
       
        
   
    });
    $app->get('/cadastroComprador/', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
    
         
         
        return $container->get('renderer')->render($response, 'cadastroComprador.phtml', $args);
       
        
   
    });

    $app->POST('/compradorCad/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        $conexao = $container->get('pdo');
 
        $params = $request->getParsedBody();

        $sql = 'INSERT INTO comprador VALUES("", "'.$params['nome'].'","'.$params['email'].'")';
        $resultSet = $conexao->query($sql);

        return $response->withRedirect('/home/');

        // Render index view
        return $container->get('renderer')->render($response, 'cadastroComprador.phtml', $args);


    });
    $app->get('/vendidos/', function (Request $request, Response $response, array $args) use ($container) {


        $container->get('logger')->info("Slim-Skeleton '/' route");
    
        $conexao = $container->get('pdo');
         
        $sql = 'SELECT * FROM carro where status=1';
        $resultSet = $conexao->query($sql);
        $args['vendidos'] = $resultSet;

         
        return $container->get('renderer')->render($response, 'vendidos.phtml', $args);
       
        
   
    });

  

};
