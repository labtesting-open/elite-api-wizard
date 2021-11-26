<?php

namespace Elitesports;

class Setting
{
    private $server;
    private $user;
    private $password;
    private $folder;
    private $parentFolder;
    private $version;


    public function __construct($mode = null)
    {
        if (isset($mode) && $mode == 'remote') {
            $this->setRemoteMode();
        } else {
            $this->setLocalMode();
        }
    }

    public function setLocalMode()
    {
        $this->server = 'http://127.0.0.1';
        $this->user = 'admin@wizard.com';
        $this->password = 'abc1234';
        $this->folder = '/elite-api-wizard';
        $this->parentFolder = '/labtest';
        $this->version = '/v1';
    }

    public function setRemoteMode()
    {
        $this->server = 'http://bb29-83-39-205-111.ngrok.io';
        $this->user = 'admin@wizard.com';
        $this->password = 'abc1234';
        $this->folder = '/elite-api-wizard';
        $this->parentFolder = '/labtest';
        $this->version = '/v1';
    }

    public function setParams($server, $user, $password, $folder, $parentFolder, $version)
    {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->folder = $folder;
        $this->parentFolder = $parentFolder;
        $this->version = $version;
    }

    /*
    server
    */
    public function getServer()
    {
        return $this->server;
    }

    public function setServer($server)
    {
        $this->server = $server;
    }

    /*
    user
    */

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    /*
    password
    */

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    /*
    folder (apiFolder)
    */

    public function getApiFolder()
    {
        return $this->folder;
    }

    public function setApiFolder($apiFolder)
    {
        $this->folder = $apiFolder;
    }

    /*
    version
    */

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    /*
    parenFolder
    */

    public function getParentFolder()
    {
        return $this->parentFolder;
    }

    public function setParentFolder($parentFolder)
    {
        $this->parentFolder = $parentFolder;
    }

    public function getBodyWithCredentials()
    {
        return '{"user":"' . $this->user . '","password":"' . $this->password . '"}';
    }

    public function getHeaderWithAuthorization($token)
    {
        return "[
            Content-Type => application/x-www-form-urlencoded,
            Authorization => Bearer $token
        ]";
    }

    public function getApiUrl()
    {
        return $this->server . $this->parentFolder . $this->folder . $this->version;
    }
}
