<?php

$app->group('/adm', function() {

    $this->get('', function() {
        return '<h1>uWebService</h1>';
    });

    $this->group('/v1', function() {
        $this->group('/auth', function() {
            $this->post('', \App\Adm\v1\Controllers\AuthController::class);
        });
    });
});
