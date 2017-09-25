<?php

$app->group('/alerta-risco', function() {

    $this->group('/v1', function() {

        $this->group('/alerta', function() {
            $this->get('', '\App\AlertaRisco\v1\Controllers\AlertaController:listAll');
            $this->post('', '\App\AlertaRisco\v1\Controllers\AlertaController:create');
            $this->get('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\AlertaController:view');
            $this->put('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\AlertaController:update');
            $this->delete('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\AlertaController:delete');
        });

        $this->group('/natureza-alerta', function() {
            $this->get('', '\App\AlertaRisco\v1\Controllers\NaturezaAlertaController:listAll');
            $this->post('', '\App\AlertaRisco\v1\Controllers\NaturezaAlertaController:create');
            $this->get('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\NaturezaAlertaController:view');
            $this->put('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\NaturezaAlertaController:update');
            $this->delete('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\NaturezaAlertaController:delete');
        });

        $this->group('/alerta-usuario', function() {
            $this->get('', '\App\AlertaRisco\v1\Controllers\AlertaUsuarioController:listAll');
            $this->post('', '\App\AlertaRisco\v1\Controllers\AlertaUsuarioController:create');
            $this->get('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\AlertaUsuarioController:view');
            $this->put('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\AlertaUsuarioController:update');
            $this->delete('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\AlertaUsuarioController:delete');
        });

        $this->group('/usuario', function() {
            $this->get('', '\App\AlertaRisco\v1\Controllers\UsuarioController:listAll');
            $this->post('', '\App\AlertaRisco\v1\Controllers\UsuarioController:create');
            $this->get('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\UsuarioController:view');
            $this->put('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\UsuarioController:update');
            $this->delete('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\UsuarioController:delete');
        });

        $this->group('/perfil-acesso', function() {
            $this->get('', '\App\AlertaRisco\v1\Controllers\PerfilAcessoController:listAll');
            $this->post('', '\App\AlertaRisco\v1\Controllers\PerfilAcessoController:create');
            $this->get('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\PerfilAcessoController:view');
            $this->put('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\PerfilAcessoController:update');
            $this->delete('/{id:[0-9]+}', '\App\AlertaRisco\v1\Controllers\PerfilAcessoController:delete');
        });

        $this->group('/auth', function() {
            $this->post('', \App\AlertaRisco\v1\Controllers\AuthController::class);
        });
    });
});
