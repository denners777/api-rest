<?php

use Psr7Middlewares\Middleware\TrailingSlash;
use Monolog\Logger;
use Slim\Middleware\JwtAuthentication;

date_default_timezone_set('America/Sao_paulo');

if (PHP_SAPI == 'cli-server') {
    $url = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI'));
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

if (getenv('DEBUG')) {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
}

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('DEBUG'),
    ]
        ]);

$container = $app->getContainer();

$container['debug'] = getenv('DEBUG');

//Serviço de Logging em Arquivo
$container['logger'] = function() {
    $logger = new Logger('app');
    $logfile = __DIR__ . '/logs/' . date('Y-m-d') . '.log';
    $stream = new Monolog\Handler\StreamHandler($logfile, Monolog\Logger::DEBUG);
    $fingersCrossed = new Monolog\Handler\FingersCrossedHandler(
            $stream, Monolog\Logger::INFO);
    $logger->pushHandler($fingersCrossed);

    return $logger;
};

// Converte os Exceptions Genéricas dentro da Aplicação em respostas JSON
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;

        $container->get('logger')->addError($exception->getMessage(), [
            'msg'   => $exception->getMessage(),
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);
        return $container['response']->withStatus($statusCode)
                        ->withHeader('Content-Type', 'Application/json')
                        ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};

//Converte os Exceptions de Erros 405 - Not Allowed
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $container['response']
                        ->withStatus(405)
                        ->withHeader('Allow', implode(', ', $methods))
                        ->withHeader('Content-Type', 'Application/json')
                        ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
                        ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
    };
};

//Converte os Exceptions de Erros 404 - Not Found
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
                        ->withStatus(404)
                        ->withHeader('Content-Type', 'Application/json')
                        ->withJson(['message' => 'Page not found']);
    };
};

/**
 * @Middleware Tratamento da / do Request
 * true - Adiciona a / no final da URL
 * false - Remove a / no final da URL
 */
$app->add(new TrailingSlash(false));

/**
 * Proxys confiáveis
 */
//$trustedProxies = ['0.0.0.0', '127.0.0.1'];
//$app->add(new RKA\Middleware\SchemeAndHost($trustedProxies));

$container['jwt'] = function ($container) {
    return new StdClass;
};

$passthrough = ['/adm/v1/auth'];

$jwtAuthenticator = new JwtAuthentication([
    'secret'      => getenv('JWT_SECRET'),
    'path'        => '/',
    'passthrough' => $passthrough,
    'header'      => 'Bearer',
    'regexp'      => '/(.*)/',
    'logger'      => $container->get('logger'),
    'secure'      => false,
    'callback'    => function ($request, $response, $arguments) use ($container) {
        $container['jwt'] = $arguments['decoded'];
    },
    'error'           => function ($request, $response, $arguments) {
        $data['status'] = 'error';
        $data['message'] = $arguments['message'];
        return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withJson($data);
    }
        ]);

$app->add($jwtAuthenticator);
$app->add(new \CorsSlim\CorsSlim(["origin" => getenv('REQUEST_ORIGIN')]));
