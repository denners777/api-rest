<?php

namespace App\Adm\v1\Models;

use App\Libraries\DB\Connect;

class FuncionarioHistorico extends Connect
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setHist($user, $event)
    {
        $id = $this->getMaxId('FUNCIONARIO_HISTORICO', 'COD_HISTORICO')['id'];

        $date = new \DateTime();
        $data = $date->format('d-m-Y H:i:s');
        $hora = $date->format('H:i:s');
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

        $sth = $this->db->prepare("INSERT INTO FUNCIONARIO_HISTORICO (COD_HISTORICO, COD_USU, DATA_HIST, HORA_HIST, EVENTO, IP)
                                    VALUES ({$id}, {$user}, '{$data}', '{$hora}', '{$event}', '{$ip}' )");
        $sth->execute();

        return $id;
    }

}
