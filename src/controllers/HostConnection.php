<?php
namespace Elitesports;

class HostConnection
{

    public $development = array("connection:"=>array(
        "server" => "localhost",
        "user" => "root",
        "password"   => "",
        "database" => "elites17_wizard",
        "port"  =>"3306"
    ));

    public $infinity = array("connection:"=>array(
        "server" => "sql104.epizy.com",
        "user" => "epiz_29881152",
        "password"   => "HgSDuwugJ29lxwM",
        "database" => "epiz_29881152_wizard",
        "port"  =>"3306"
    ));


    public function getParams()
    {   
        return $this->development;
    }

}



