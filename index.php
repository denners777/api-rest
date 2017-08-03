<?php

$loader = require 'vendor/autoload.php';

$app = new \Slim\Slim(['templates.path' => 'templates']);

$app->get('/pessoas/', function() use ($app) {
    (new \controllers\Pessoa($app))->lista();
});

$app->get('/pessoas/:id', function($id) use ($app) {
    (new \controllers\Pessoa($app))->get($id);
});

$app->post('/pessoas/', function() use ($app) {
    (new \controllers\Pessoa($app))->nova();
});

$app->put('/pessoas/:id', function($id) use ($app) {
    (new \controllers\Pessoa($app))->editar($id);
});

$app->delete('/pessoas/:id', function($id) use ($app) {
    (new \controllers\Pessoa($app))->excluir($id);
});

$app->run();
