<?php

namespace App\AlertaRisco\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\AlertaRisco\v1\Models\Alerta;

/**
 * Controller v1 de Alerta
 */
class AlertaController
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
     * Listagem de Alerta
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function listAll(Request $request, Response $response, $args)
    {
        $alerta = (new Alerta())->findAll();
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Cria um Alerta
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function create(Request $request, Response $response, $args)
    {
        $params = $request->getParams();

        $alerta = (new Alerta())->create($params);

        $logger = $this->container->get('logger');
        $logger->info('Alerta Criado!', $alerta);

        $return = $response->withJson($alerta, 201)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Exibe as informações de um Alerta 
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function view(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $alerta = (new Alerta())->find($id);
        if (!$alerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Alerta {$id} não encontrado");
            throw new \Exception('Alerta não encontrado', 404);
        }
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Atualiza um Alerta
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function update(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new Alerta())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Alerta {$id} não encontrado");
            throw new \Exception('Alerta não encontrado', 404);
        }
        $alerta = (new Alerta())->update($id, $request->getParams());
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Deleta um Alerta
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function delete(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $getAlerta = (new Alerta())->find($id);
        if (!$getAlerta) {
            $logger = $this->container->get('logger');
            $logger->warning("Alerta {$id} não encontrado");
            throw new \Exception('Alerta não encontrado', 404);
        }
        $alerta = (new Alerta())->delete($id);
        $return = $response->withJson(['msg' => "Deletando o alerta {$id}"], 204)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

}
