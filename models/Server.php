<?php

namespace Modules\Minecraftserver\Models;

class Server extends \Ilch\Model {

    protected $id;
    protected $minecraftserver;
    protected $port;
    protected $timeout;
    protected $hostname;
    protected $gametype;
    protected $game_id;
    protected $version;
    protected $plugins;
    protected $map;
    protected $numplayers;
    protected $maxplayers;
    protected $hostport;
    protected $hostip;
    protected $online;
    protected $software;
    protected $description;
    protected $serverpinginfo;
    protected $players;
    protected $name;
    protected $protocol;
    protected $modinfo;
    protected $type;
    protected $modList;
    protected $modid;
        
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setMinecraftserver($minecraftserver)
    {
        $this->minecraftserver = $minecraftserver;

        return $this;
    }
    
    public function getMinecraftserver()
    {
        return $this->minecraftserver;
    }
    
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }
    
    public function getPort()
    {
        return $this->port;
    }
    
    public function setTimeouit($timeout)
    {
        $this->timeout = $timeout;
        
        return $this;
    }
    
    public function getTimeout()
    {
        return $this->timeout;
    }
    
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }
    
    public function getHostname()
    {
        return $this->hostname;
    }
    
    public function setGametype($gametype)
    {
        $this->gametype = $gametype;

        return $this;
    }
    
    public function getGametype()
    {
        return $this->gametype;
    }
    
    public function setGame_id($game_id)
    {
        $this->game_id = $game_id;

        return $this;
    }
    
    public function getGame_id()
    {
        return $this->game_id;
    }
    
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function setPlugins($plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }
    
    public function getPlugins()
    {
        return $this->plugins;
    }
    
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }
    
    public function getMap()
    {
        return $this->map;
    }
    
    public function setNumplayers($numplayers)
    {
        $this->numplayers = $numplayers;

        return $this;
    }
    
    public function getNumplayers()
    {
        return $this->numplayers;
    }
    
    public function setMaxplayers($maxplayers)
    {
        $this->maxplayers = $maxplayers;

        return $this;
    }
    
    public function getMaxplayers()
    {
        return $this->maxplayers;
    }
    
    public function setHostport($hostport)
    {
        $this->hostport = $hostport;

        return $this;
    }
    
    public function getHostport()
    {
        return $this->hostport;
    }
    
    public function setHostip($hostip)
    {
        $this->hostip = $hostip;

        return $this;
    }
    
    public function getHostip()
    {
        return $this->hostip;
    }
    
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }
    
    public function getOnline()
    {
        return $this->online;
    }
    
    public function setSoftware($software)
    {
        $this->software = $software;

        return $this;
    }
    
    public function getSoftware()
    {
        return $this->software;
    }
    
    public function setDiscription($description)
    {
        $this->discription = $discription;

        return $this;
    }
    
    public function getDiscription()
    {
        return $this->discription;
    }
    
    public function setServerpinginfo($serverpinginfo)
    {
        $this->serverpinginfo = $serverpinginfo;

        return $this;
    }
    
    public function getServerpinginfo()
    {
        return $this->serverpinginfo;
    }
    
    public function setPlayers($players)
    {
        $this->players = $players;

        return $this;
    }
    
    public function getPlayers()
    {
        return $this->players;
    }
    
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }
    
    public function getProtocol()
    {
        return $this->protocol;
    }
    
    public function setModinfo($modinfo)
    {
        $this->modinfo = $modinfo;

        return $this;
    }
    
    public function getModinfo()
    {
        return $this->modinfo;
    }
    
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setModList($modList)
    {
        $this->modList = $modList;

        return $this;
    }
    
    public function getModList()
    {
        return $this->modList;
    }
    
    public function setModid($modid)
    {
        $this->modid = $modid;

        return $this;
    }
    
    public function getModid()
    {
        return $this->modid;
    }

}
