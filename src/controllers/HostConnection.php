<?php

namespace Elitesports;

class HostConnection
{

    private $host = array('connection:' => array(
        'server' => 'localhost',
        'user' => 'root',
        'password'   => '',
        'database' => 'elites17_wizard',
        'port'  => '3306'
    ));


    public function getParams()
    {
        return $this->host;
    }
}
