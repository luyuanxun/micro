<?php

use Phalcon\Crypt;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});


/**
 * dbMaster
 */
$di->setShared('dbMaster', function () {
    $db = $this->getConfig()->db->master;
    return new MysqlPdo(
        [
            'host' => $db->host,
            'username' => $db->username,
            'password' => $db->password,
            'dbname' => $db->dbname,
            'charset' => $db->charset
        ]
    );
});


/**
 * dbSlave
 */
$di->setShared('dbSlave', function () {
    $db = $this->getConfig()->db->slave;
    return new MysqlPdo(
        [
            'host' => $db->host,
            'username' => $db->username,
            'password' => $db->password,
            'dbname' => $db->dbname,
            'charset' => $db->charset
        ]
    );
});