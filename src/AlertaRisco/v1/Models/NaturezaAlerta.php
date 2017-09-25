<?php

namespace App\AlertaRisco\v1\Models;

use App\Libraries\DB\Connect;
use Valitron\Validator;

class NaturezaAlerta extends Connect
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @return type
     */
    public function findAll()
    {
        $fields = [];
        foreach ($this->columnMap() as $key => $value) {
            $fields[] = $value . ' AS ' . $key;
        }
        $sth = $this->db->prepare("SELECT " . implode(', ', $fields) . " FROM AR_Natureza_Alerta");
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param int $id
     * @return PDO
     */
    public function find($id)
    {
        $fields = [];
        foreach ($this->columnMap() as $key => $value) {
            $fields[] = $value . ' AS ' . $key;
        }
        $sth = $this->db->prepare("SELECT " . implode(', ', $fields) . " FROM AR_Natureza_Alerta WHERE Cod_Natureza = :id");
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param array $dados
     * @return PDO
     */
    public function create(array $dados)
    {
        $validator = $this->validator($dados);
        if ($validator !== true) {
            throw new \Exception($validator, 400);
        }
        $keys = array_keys($dados);
        $fields = [];

        foreach ($keys as $field) {
            $fields[] = $this->columnMap()[$field];
        }

        $sth = $this->db->prepare("INSERT INTO AR_Natureza_Alerta (" . implode(',', $fields) . ") VALUES (:" . implode(",:", $keys) . ")");
        foreach ($dados as $key => $value) {
            $sth->bindValue(':' . $key, $value);
        }

        $sth->execute();

        return ['id' => $this->db->lastInsertId()];
    }

    /**
     *
     * @param int $id
     * @param array $dados
     * @return boolean
     */
    public function update($id, array $dados)
    {

        $validator = $this->validator($dados);

        if ($validator !== true) {
            throw new \Exception($validator, 400);
        }
        $sets = [];
        foreach ($dados as $key => $value) {
            $sets[] = $this->columnMap()[$key] . " = :" . $key;
        }

        $sth = $this->db->prepare("UPDATE AR_Natureza_Alerta SET " . implode(', ', $sets) . " WHERE Cod_Natureza = :id");
        $sth->bindValue(':id', $id);
        foreach ($dados as $key => $value) {
            $sth->bindValue(':' . $key, $value);
        }
        
        return $sth->execute() == 1;
    }

    /**
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $sth = $this->db->prepare("DELETE FROM AR_Natureza_Alerta WHERE Cod_Natureza = :id");
        $sth->bindValue(':id', $id);
        return $sth->execute() == 1;
    }

    /**
     *
     * @param type $request
     * @return boolean
     */
    private function validator($request)
    {
        $v = new Validator($request);
        $v->rule('required', ['name'])->message('O campo {field} é obrigatório');
        $v->labels([
            'name' => 'Nome',
        ]);
        if ($v->validate()) {
            return true;
        }
        $return = '';
        foreach ($v->errors() as $error) {
            $return .= $error[0];
        }
        return $return;
    }

    /**
     *
     * @return type
     */
    private function columnMap()
    {
        return [
            'id'   => 'Cod_Natureza',
            'name' => 'Natureza',
        ];
    }

}
