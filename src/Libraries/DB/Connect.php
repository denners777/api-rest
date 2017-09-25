<?php

namespace App\Libraries\DB;

class Connect
{

    /**
     *
     * @var type 
     */
    protected $db;

    /**
     * 
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * 
     * @return \PDO
     */
    private function connect()
    {
        $dbh = new \PDO('sqlsrv:Server=' . getenv('DB_HOST') . ';Database=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
        if (getenv('DEBUG')) {
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        $sql = "SET LANGUAGE 'Português (Brasil)'";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        return $dbh;
    }

    /**
     * 
     * @param type $table
     * @param type $field
     * @return type
     */
    public function getMaxId($table, $field)
    {
        $sth = $this->db->prepare("SELECT ISNULL(MAX($field), 0) + 1 AS id FROM $table");
        $sth->execute();
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

}
