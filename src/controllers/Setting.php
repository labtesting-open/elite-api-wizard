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
        $this->server = 'http://localhost';
        $this->user = 'elitesports17';
        $this->password = 'abc1234';
        $this->folder = '/elite-api-wizard';
        $this->parentFolder = '/labtest';
        $this->version = '/v1';
    }

    public function setRemoteMode()
    {
        $this->server = 'http://df2298907fb7.ngrok.io';
        $this->user = 'elitesports17';
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

    public function getServer()
    {
        return $this->server;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getApiFolder()
    {
        return $this->folder;
    }

    public function getParentFolder()
    {
        return $this->parentFolder;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setServer($server)
    {
        $this->server = $server;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setApiFolder($apiFolder)
    {
        $this->apiFolder = $apiFolder;
    }

    public function setApiSubFolder($parentFolder)
    {
        $this->parentFolder = $parentFolder;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }
}
