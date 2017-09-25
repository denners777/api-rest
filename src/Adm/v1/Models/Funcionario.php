<?php

namespace App\Adm\v1\Models;

use App\Libraries\DB\Connect;

class Funcionario extends Connect
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($user, $pass)
    {
        $sth = $this->db->prepare("SELECT COD_USU id, RTRIM(LTRIM(LOGIN)) username, NOME name FROM FUNCIONARIOS WHERE LOGIN = :user AND SENHA = :pass");
        $sth->bindValue(':user', $user);
        $sth->bindValue(':pass', $pass);
        $sth->execute();
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

}
