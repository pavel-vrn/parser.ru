<?php
/**
 * Created by PhpStorm.
 * User: batis
 * Date: 17.09.2018
 * Time: 21:07
 */

class Pdo_Helper
{
    private static $_instance;

    private $_db_file = "./verbs_db.db";

    private $_user = "";

    private $_password = "";

    private $_dsn;

    public static function singleton()
    {
        if (!isset(self::$_instance)) {
            $c = __CLASS__;
            try {
                self::$_instance = new $c;
            } catch (Exception $e) {
                header('location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }
        return self::$_instance;
    }

    /**
     * Создание экземпляра с помощью new невозможно
     *
     * @return void
     */
    public function __clone()
    {
        trigger_error(CLONE_IS_NOT_ALLOWED, E_USER_ERROR);
    }

    private function __construct() {
        $this->_dsn = "sqlite:" . $this->_db_file;
        $this->PDO_Connect();
    }

    private function PDO_Connect()
    {
        global $PDO;
        $PDO = new PDO($this->_dsn, $this->_user, $this->_password);
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    public function PDO_FetchOne($query, $params=null)
    {
        global $PDO;
        if (isset($params)) {
            $stmt = $PDO->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $PDO->query($query);
        }
        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            return $row[0];
        } else {
            return false;
        }
    }
    public function PDO_FetchRow($query, $params=null)
    {
        global $PDO;
        if (isset($params)) {
            $stmt = $PDO->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $PDO->query($query);
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function PDO_FetchAll($query, $params=null)
    {
        global $PDO;
        if (isset($params)) {
            $stmt = $PDO->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $PDO->query($query);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function PDO_FetchAssoc($query, $params=null)
    {
        global $PDO;
        if (isset($params)) {
            $stmt = $PDO->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $PDO->query($query);
        }
        $rows = $stmt->fetchAll(PDO::FETCH_NUM);
        $assoc = array();
        foreach ($rows as $row) {
            $assoc[$row[0]] = $row[1];
        }
        return $assoc;
    }
    public function PDO_Execute($query, $params=null)
    {
        global $PDO;
        if (isset($params)) {
            $stmt = $PDO->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } else {
            return $PDO->query($query);
        }
    }
    public function PDO_LastInsertId()
    {
        global $PDO;
        return $PDO->lastInsertId();
    }
    function PDO_ErrorInfo()
    {
        global $PDO;
        return $PDO->errorInfo();
    }
}
