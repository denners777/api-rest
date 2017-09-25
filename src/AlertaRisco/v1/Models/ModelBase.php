<?php

namespace App\AlertaRisco\v1\Models;

use PDO;

class ModelBase
{

    /**
     *
     * @var type
     */
    private $db;

    /**
     *
     * @var type
     */
    private $class;

    /**
     *
     * @var type
     */
    private $table;

    /**
     *
     * @var type
     */
    private $distinct;

    /**
     *
     * @var type
     */
    private $fields;

    /**
     *
     * @var type
     */
    private $join;

    /**
     *
     * @var type
     */
    private $where;

    /**
     *
     * @var type
     */
    private $groupBy;

    /**
     *
     * @var type
     */
    private $orderBy;

    /**
     *
     * @return $this
     */
    private function setClass()
    {
        $this->class = get_class($this);
        return $this;
    }

    /**
     *
     * @return $this
     */
    private function table($table = '')
    {
        if (!isset($args['table'])or ( isset($args['table']) and empty($args['table']))) {
            $class = $this->class;
            $table = $class::TABLE;
        } else {
            $table = $args['table'];
        }
        $this->table = $table;
        return $this;
    }

    /**
     *
     * @param type $args
     * @return $this
     */
    public function distinct($args)
    {
        if (isset($args['distinct']) and $args['distinct']) {
            $this->distinct = 'DISTINCT';
        }
        $this->distinct = '';
        return $this;
    }

    /**
     *
     * @param type $args
     * @return $this
     */
    public function fields($args)
    {
        if (!isset($args['fields']) or ( isset($args['fields']) and empty($args['fields']))) {
            $class = $this->class;
            $fields = $class::columnMap();
        } else {
            $fields = $args['fields'];
        }
        $this->fields = $this->makeFields($fields);
        return $this;
    }

    /**
     *
     * @param type $args
     * @return $this
     */
    public function joins($args)
    {
        if (!isset($args['joins']) or ( isset($args['joins']) and empty($args['joins']))) {
            if (method_exists(get_called_class(), 'joins') === false) {
                $class = $this->class;
                foreach ((new $class())->joins() as $join) {
                    $joins .= $join;
                }
            } else {
                $joins = '';
            }
        } else {
            $joins = $args['joins'];
        }
        $this->join = $joins;
        return $this;
    }

    /**
     *
     * @param type $args
     * @return $this
     */
    public function where($args)
    {
        if (isset($args['where']) and ! empty($args['where'])) {
            $where = 'WHERE ' . $args['where'];
        } else {
            $where = '';
        }
        $this->where = $where;
        return $this;
    }

    /**
     *
     * @param type $args
     * @return $this
     */
    public function groupBy($args)
    {
        if (isset($args['groupBy']) and ! empty($args['groupBy'])) {
            $groupBy = 'GROUP BY ' . $args['groupBy'];
        } else {
            $groupBy = '';
        }
        $this->groupBy = $groupBy;
        return $this;
    }

    /**
     *
     * @param type $orderBy
     * @return $this
     */
    public function orderBy($orderBy)
    {
        if (isset($args['orderBy']) and ! empty($args['orderBy'])) {
            $orderBy = 'ORDER BY ' . $args['orderBy'];
        } else {
            $orderBy = 'ORDER BY 1';
        }
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     *
     */
    public function __construct()
    {
        $this->db = $this->connect();
        $this->setClass();
    }

    /**
     *
     * @return PDO
     */
    private function connect()
    {

        $dbh = new PDO('sqlsrv:Server=' . getenv('DB_HOST') . ';Database=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SET LANGUAGE 'Português (Brasil)'";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        return $dbh;
    }

    public function findAll($args = [])
    {
        $this->fields($args);
        $this->table($args);
        $this->joins($args);
        $this->orderBy($args);
        return $this->read();
    }

    public function find($args = [])
    {
        $this->distinct($args);
        $this->fields($args);
        $this->table($args);
        $this->joins($args);
        $this->where($args);
        $this->groupBy($args);
        $this->orderBy($args);
        return $this->read();
    }

    public function read()
    {
        $sql = "SELECT {$this->distinct} {$this->fields} FROM {$this->table} {$this->join} {$this->where} {$this->groupBy} {$this->orderCol}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    private function makeFields($fields)
    {
        $return = '';
        foreach ($fields as $key => $value) {
            $return .= $value . ' AS ' . $key . ', ';
        }
        return substr($return, 0, -2);
    }

    private function makeJoins($joins)
    {
        $return = '';
        foreach ($joins as $join) {
            $return .= $join;
        }
    }

    /* public function read($sql, $return = 'FA')
      {

      $this->conexao->select($sql);

      switch ($return) {
      case 'FY' :
      return $this->conexao->getFetchArray();
      case 'F' :
      return $this->conexao->getFetch();
      case 'NR' :
      return $this->conexao->getNumRows();
      default :
      return $this->conexao->getFetchAssoc();
      }
      } */

    public function create($sql)
    {
        return $this->conexao->create($sql);
    }

    public function update($sql)
    {
        return $this->conexao->update($sql);
    }

    public function delete($sql)
    {
        return $this->conexao->delete($sql);
    }

    public function getMaxId($table, $field)
    {
        return $this->conexao->getMaxId($table, $field);
    }

}
