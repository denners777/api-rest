<?php

namespace App\AlertaRisco\v1\Models;

class Uniframework extends \DataBase
{

    public function __construct()
    {
        parent::__construct();
        parent::Conectar();
    }

    /**
     *
     * @param type $sql
     * @return type
     */
    public function select($sql = '')
    {
        $this->Select = $sql;
        return parent::Select();
    }

    /**
     *
     * @param type $sql
     * @return type
     */
    public function create($sql = '')
    {
        $this->Insert = $sql;
        if (parent::Inserir()) {
            return $this->getLastInsertId() == '' ? 1 : $this->getLastInsertId();
        }
        return false;
    }

    /**
     *
     * @param type $sql
     * @return type
     */
    public function update($sql = '')
    {
        $this->Update = $sql;
        return parent::Atualizar();
    }

    /**
     *
     * @param type $sql
     * @return type
     */
    public function delete($sql = '')
    {
        $this->Delete = $sql;
        return parent::Deletar();
    }

    /**
     *
     * @return type
     */
    public function getFetchAssoc()
    {
        return parent::getFetchAssoc();
    }

    /**
     *
     * @return type
     */
    public function getFetchArray()
    {
        return parent::getFetchArray();
    }

    /**
     *
     * @return type
     */
    public function getFetch()
    {
        return parent::fetch();
    }

    /**
     *
     * @return type
     */
    public function getNumRows()
    {
        return parent::getNumRows();
    }

    /**
     *
     * @param type $table
     * @param type $field
     * @return type
     */
    public function getMaxId($table, $field)
    {
        $sql = "SELECT MAX($field) + 1 AS id FROM $table";

        $this->select($sql);
        $id = $this->getFetchAssoc();
        return (int) $id['id'];
    }

    /**
     *
     * @return type
     */
    public function disconect()
    {
        return parent::Desconectar();
    }

}
