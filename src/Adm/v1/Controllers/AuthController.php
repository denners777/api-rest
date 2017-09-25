<?php

namespace App\Adm\v1\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use App\Adm\v1\Models\Funcionario;
use App\Adm\v1\Models\FuncionarioHistorico;

class AuthController
{

    /**
     * Container
     * @var object s
     */
    protected $container;

    /**
     * Undocumented function
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Invokable Method
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function __invoke(Request $request, Response $response, $args)
    {

        $params = (object) $request->getParams();

        $user = (new Funcionario())->get($params->username, $params->password);

        if (!$user) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuário {$params->username} não encontrado");
            throw new \Exception("Usuário não encontrado", 404);
        }
        
        (new FuncionarioHistorico)->setHist($user['id'], 'Login Alerta de Risco');
        
        $key = getenv('JWT_SECRET');
        $token = [
            'iss'     => getenv('JWT_NAMESPACE'),
            'iat'     => time(),
            'exp'     => time() + (3600 * 8),
            'context' => [
                'user' => [
                    'userName' => $user['username'],
                    'userId'   => $user['id']
                ]
            ]
        ];
        $jwt = JWT::encode($token, $key);

        $return = [
            'token' => $jwt,
            'user'  => $user
        ];

        return $response->withJson($return, 200)
                        ->withHeader('Content-type', 'application/json');
    }

}
