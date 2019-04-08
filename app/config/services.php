<?php

use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;

/**
 * dbMaster
 */
$di->setShared('dbMaster', function () use ($config) {
    return new MysqlPdo(
        [
            'host' => $config->db->master->host,
            'username' => $config->db->master->username,
            'password' => $config->db->master->password,
            'dbname' => $config->db->master->dbname,
            'charset' => $config->db->master->charset
        ]
    );
});


/**
 * dbSlave
 */
$di->setShared('dbSlave', function () use ($config) {
    return new MysqlPdo(
        [
            'host' => $config->db->slave->host,
            'username' => $config->db->slave->username,
            'password' => $config->db->slave->password,
            'dbname' => $config->db->slave->dbname,
            'charset' => $config->db->slave->charset
        ]
    );
});