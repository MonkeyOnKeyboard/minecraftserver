<?php

namespace Modules\Minecraftserver\Models;

class Server extends \Ilch\Model
{
    /**
     * @var int
     */
    protected $id = 0;
    /**
     * @var string
     */
    protected $minecraftserver = '';
    /**
     * @var int
     */
    protected $port = 25565;
    /**
     * @var int
     */
    protected $timeout = 10;
    /**
     * @var string
     */
    protected $hostname = '';
    /**
     * @var string
     */
    protected $gametype = '';
    /**
     * @var string
     */
    protected $game_id = '';
    /**
     * @var string
     */
    protected $version = '';
    /**
     * @var string
     */
    protected $plugins = '';
    /**
     * @var string
     */
    protected $map = '';
    /**
     * @var int
     */
    protected $numplayers = 0;
    /**
     * @var int
     */
    protected $maxplayers = 0;
    /**
     * @var int
     */
    protected $hostport = 0;
    /**
     * @var string
     */
    protected $hostip = '';
    /**
     * @var bool
     */
    protected $online = false;
    /**
     * @var string
     */
    protected $software = '';
    /**
     * @var string
     */
    protected $description = '';
    /**
     * @var string
     */
    protected $serverpinginfo = '';
    /**
     * @var string
     */
    protected $players = '';
    /**
     * @var array
     */
    protected $serverinfo = [];
    /**
     * @var string
     */
    protected $updatetime = '';

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): Server
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $minecraftserver
     * @return $this
     */
    public function setMinecraftserver(string $minecraftserver): Server
    {
        $this->minecraftserver = $minecraftserver;

        return $this;
    }

    /**
     * @return string
     */
    public function getMinecraftserver(): string
    {
        return $this->minecraftserver;
    }

    /**
     * @param int $port
     * @return $this
     */
    public function setPort(int $port): Server
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $timeout
     * @return $this
     */
    public function setTimeout(int $timeout): Server
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param string $hostname
     * @return $this
     */
    public function setHostname(string $hostname): Server
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $gametype
     * @return $this
     */
    public function setGametype(string $gametype): Server
    {
        $this->gametype = $gametype;

        return $this;
    }

    /**
     * @return string
     */
    public function getGametype(): string
    {
        return $this->gametype;
    }

    /**
     * @param string $game_id
     * @return $this
     */
    public function setGameId(string $game_id): Server
    {
        $this->game_id = $game_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getGameId(): string
    {
        return $this->game_id;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): Server
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $plugins
     * @return $this
     */
    public function setPlugins(string $plugins): Server
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlugins(): string
    {
        return $this->plugins;
    }

    /**
     * @param string $map
     * @return $this
     */
    public function setMap(string $map): Server
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return string
     */
    public function getMap(): string
    {
        return $this->map;
    }

    /**
     * @param int $numplayers
     * @return $this
     */
    public function setNumplayers(int $numplayers): Server
    {
        $this->numplayers = $numplayers;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumplayers(): int
    {
        return $this->numplayers;
    }

    /**
     * @param int $maxplayers
     * @return $this
     */
    public function setMaxplayers(int $maxplayers): Server
    {
        $this->maxplayers = $maxplayers;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxplayers(): int
    {
        return $this->maxplayers;
    }

    /**
     * @param int $hostport
     * @return $this
     */
    public function setHostport(int $hostport): Server
    {
        $this->hostport = $hostport;

        return $this;
    }

    /**
     * @return int
     */
    public function getHostport(): int
    {
        return $this->hostport;
    }

    /**
     * @param string $hostip
     * @return $this
     */
    public function setHostip(string $hostip): Server
    {
        $this->hostip = $hostip;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostip(): string
    {
        return $this->hostip;
    }

    /**
     * @param bool $online
     * @return $this
     */
    public function setOnline(bool $online): Server
    {
        $this->online = $online;

        return $this;
    }

    public function getOnline(): bool
    {
        return $this->online;
    }

    /**
     * @param string $software
     * @return $this
     */
    public function setSoftware(string $software): Server
    {
        $this->software = $software;

        return $this;
    }

    /**
     * @return string
     */
    public function getSoftware(): string
    {
        return $this->software;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Server
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $serverpinginfo
     * @return $this
     */
    public function setServerpinginfo(string $serverpinginfo): Server
    {
        $this->serverpinginfo = $serverpinginfo;

        return $this;
    }

    /**
     * @return string
     */
    public function getServerpinginfo(): string
    {
        return $this->serverpinginfo;
    }

    /**
     * @param string $players
     * @return $this
     */
    public function setPlayers(string $players): Server
    {
        $this->players = $players;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlayers(): string
    {
        return $this->players;
    }

    /**
     * @param array $serverinfo
     * @return $this
     */
    public function setServerInfo(array $serverinfo): Server
    {
        $this->serverinfo = $serverinfo;

        return $this;
    }

    /**
     * @return array
     */
    public function getServerInfo(): array
    {
        return $this->serverinfo;
    }

    /**
     * @param string $updatetime
     * @return $this
     */
    public function setUpdateTime(string $updatetime): Server
    {
        $this->updatetime = $updatetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdateTime(): string
    {
        return $this->updatetime;
    }
}
