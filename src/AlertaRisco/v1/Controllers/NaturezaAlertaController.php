<?php

namespace App\AlertaRisco\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\AlertaRisco\v1\Models\NaturezaAlerta;

/**
 * Controller v1 de Natureza de Alerta
 */
class NaturezaAlertaController
{

    /**
     * Container Class
     * @var [object]
     */
    private $container;

    /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Listagem de Natureza de Alerta
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function listAll(Request $request, Response $response, $args)
    {
        $alerta = (new NaturezaAlerta())->findAll();
        $return = $response->withJson($alerta, 200)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Cria um Natureza de Alerta
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     */
    public function create(Request $request, Response $response, $args)
    {
        $params = $request->getParams();

        $alerta = (new NaturezaAlerta())->create($params);

        if ($this->container->get('debug')) {
            $logger = $this->container->get('logger');
            $logger->info('Natureza de Alerta Criado!', $alerta);
        }

        $return = $response->withJson($alerta, 201)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * Exibe as informações de uma Natureza de Alerta
     * @param Request $request
     * @param Response $response
     * @param type $args
     * @return Response
     * @throws \Exception
     */
    public function view(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $alerta = (new NaturezaAlerta())->find($id);
        if (!$alerta) {
            if ($this->container->get('debug')) {
                $logger = $this->container->get('logger');
                $logger->warning("Natureza de Alerta {$id} não encontrado");
            }
            throw new \Exception('Natureza de Alerta não encontrado', 404);
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
        $getAlerta = (new NaturezaAlerta())->find($id);
        if (!$getAlerta) {
            if ($this->container->get('debug')) {
                $logger = $this->container->get('logger');
                $logger->warning("Natureza de Alerta {$id} não encontrado");
            }
            throw new \Exception('Natureza de Alerta não encontrado', 404);
        }
        $alerta = (new NaturezaAlerta())->update($id, $request->getParams());
        print_r($alerta);exit;
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
        $getAlerta = (new NaturezaAlerta())->find($id);
        if (!$getAlerta) {
            if ($this->container->get('debug')) {
                $logger = $this->container->get('logger');
                $logger->warning("Natureza de Alerta {$id} não encontrado");
            }
            throw new \Exception('Natureza de Alerta não encontrado', 404);
        }
        $delete = (new NaturezaAlerta())->delete($id);
        if(!$delete){
            throw new \Exception("Natureza de Alerta {$id} não deletado", 406);
        }
        $return = $response->withJson(['msg' => "Deletando a Natureza de Alerta {$id}"], 204)
                ->withHeader('Content-type', 'application/json');
        return $return;
    }

}
