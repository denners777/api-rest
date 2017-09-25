<?php

namespace App\AlertaRisco\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\AlertaRisco\v1\Models\PerfilAcesso;

/**
 * Controller v1 de Perfil de Acesso
 */
class PerfilAcessoController
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
     * Listagem de Perfil de Acesso
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function listAll(Request $request, Response $response, $args)
    {
        $alerta = (new PerfilAcesso())->findAll();
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Cria um Perfil de Acesso
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function create(Request $request, Response $response, $args)
    {
        $params = $request->getParams();

        $alerta = (new PerfilAcesso())->create($params);

        $logger = $this->container->get('logger');
        $logger->info('Alerta Criado!', $alerta);

        $return = $response->withJson($alerta, 201)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Exibe as informações de um Perfil de Acesso
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function view(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $alerta = (new PerfilAcesso())->find($id);
        if (!$alerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Perfil de Acesso {$id} não encontrado");
            throw new \Exception('Perfil de Acesso não encontrado', 404);
        }
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Atualiza um Perfil de Acesso
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function update(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new PerfilAcesso())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Perfil de Acesso {$id} não encontrado");
            throw new \Exception('Perfil de Acesso não encontrado', 404);
        }
        $alerta = (new PerfilAcesso())->update($id, $request->getParams());
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Deleta um Perfil de Acesso
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function delete(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new PerfilAcesso())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Perfil de Acesso {$id} não encontrado");
            throw new \Exception('Perfil de Acesso não encontrado', 404);
        }
        $alerta = (new PerfilAcesso())->delete($id);
        $return = $response->withJson(['msg' => "Deletando o Perfil de Acesso {$id}"], 204)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

}
