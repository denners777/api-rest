<?php

namespace App\AlertaRisco\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\AlertaRisco\v1\Models\Usuario;

/**
 * Controller v1 de Usuário
 */
class UsuarioController
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
     * Listagem de Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function listAll(Request $request, Response $response, $args)
    {
        $alerta = (new Usuario())->findAll();
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Cria um Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function create(Request $request, Response $response, $args)
    {
        $params = $request->getParams();

        $alerta = (new Usuario())->create($params);

        $logger = $this->container->get('logger');
        $logger->info('Alerta Criado!', $alerta);

        $return = $response->withJson($alerta, 201)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Exibe as informações de um Usuário 
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function view(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $alerta = (new Usuario())->find($id);
        if (!$alerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuário {$id} não encontrado");
            throw new \Exception('Usuário não encontrado', 404);
        }
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Atualiza um Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function update(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new Usuario())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuário {$id} não encontrado");
            throw new \Exception('Usuário não encontrado', 404);
        }
        $alerta = (new Usuario())->update($id, $request->getParams());
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Deleta um Usuário
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function delete(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new Usuario())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuário {$id} não encontrado");
            throw new \Exception('Usuário não encontrado', 404);
        }
        $alerta = (new Usuario())->delete($id);
        $return = $response->withJson(['msg' => "Deletando o Usuário {$id}"], 204)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

}
