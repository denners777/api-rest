<?php

namespace App\AlertaRisco\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\AlertaRisco\v1\Models\AlertaUsuario;

/**
 * Controller v1 de Alerta de Usuário
 */
class AlertaUsuarioController
{

    /**
     * Container Class
     * @var [object]
     */
    private $container;

    /**
     * 
     * @param [object] $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Listagem de Alerta de Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function listAll(Request $request, Response $response, $args)
    {
        $alerta = (new AlertaUsuario())->findAll();
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Cria um Alerta de Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function create(Request $request, Response $response, $args)
    {
        $params = $request->getParams();

        $alerta = (new AlertaUsuario())->create($params);

        $logger = $this->container->get('logger');
        $logger->info('Alerta de Usuário Criado!', $alerta);

        $return = $response->withJson($alerta, 201)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Exibe as informações de um Alerta de Usuário 
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function view(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $alerta = (new AlertaUsuario())->find($id);
        if (!$alerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Alerta {$id} não encontrado");
            throw new \Exception('Alerta de Usuário não encontrado', 404);
        }
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Atualiza um Alerta de Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function update(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new AlertaUsuario())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Alerta {$id} não encontrado");
            throw new \Exception('Alerta de Usuário não encontrado', 404);
        }
        $alerta = (new AlertaUsuario())->update($id, $request->getParams());
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Deleta um Alerta de Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function delete(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new AlertaUsuario())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Alerta de Usuário {$id} não encontrado");
            throw new \Exception('Alerta de Usuário não encontrado', 404);
        }
        $alerta = (new AlertaUsuario())->delete($id);
        $return = $response->withJson(['msg' => "Deletando o Alerta de Usuário {$id}"], 204)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

}
