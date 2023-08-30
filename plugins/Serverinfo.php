<?php

namespace Modules\Minecraftserver\Plugins;

use Modules\Minecraftserver\Libs\MinecraftPing;
use Modules\Minecraftserver\Libs\MinecraftQuery;
use Modules\Minecraftserver\Models\Server as ServerModel;

class Serverinfo
{
    /**
     * @var ServerModel[]
     */
    private $server = [];
    /**
     * @var ServerModel[]
     */
    private $dataServer = [];

    /**
     * @return array|null
     */
    public function getServerData(): ?array
    {
        if (count($this->server)) {
            foreach ($this->server as $server) {
                $minecraftserver = $server->getMinecraftserver();

                $serverdata = new MinecraftQuery();
                $PingQuery = null;
                $info = [];
                $description = '';

                try {
                    $serverdata->connect($minecraftserver, $server->getPort(), $server->getTimeout());

                    if (!$serverdata->getInfo()) {
                        $serverdata->connectBedrock($minecraftserver, $server->getPort(), $server->getTimeout());
                    }

                    $PingQuery = new MinecraftPing($minecraftserver, $server->getHostport(), $server->getTimeout());
                    $info = $PingQuery->query();
                } catch (\Throwable $e) {
                    $description = $e;
                } finally {
                    if ($PingQuery) {
                        $PingQuery->close();
                    }
                }

                $model = new ServerModel();
                $model->setMinecraftserver($minecraftserver)
                    ->setHostname($serverdata->getInfo('HostName') ?? '')
                    ->setGametype($serverdata->getInfo('GameType') ?? '')
                    ->setGameId($serverdata->getInfo('GameName') ?? '')
                    ->setVersion($serverdata->getInfo('Version') ?? '')
                    ->setPlugins(serialize($serverdata->getInfo('Plugins') ?? ''))
                    ->setMap($serverdata->getInfo('Map') ?? '')
                    ->setNumplayers($serverdata->getInfo('Players') ?? 0)
                    ->setMaxplayers($serverdata->getInfo('MaxPlayers') ?? 0)
                    ->setHostip($serverdata->getInfo('HostIp') ?? '')
                    ->setHostport($serverdata->getInfo('HostPort') ?? 0)
                    ->setSoftware($serverdata->getInfo('Software') ?? '')
                    ->setOnline((bool)$serverdata->getInfo())
                    ->setPlayers(serialize($serverdata->getPlayers() ?? ''))
                    ->setServerInfo($serverdata->getInfo())
                    ->setServerpinginfo(serialize($info ?? ''))
                    ->setDescription($description);

                $this->dataServer[] = $model;
            }
            return $this->dataServer;
        } else {
            return null;
        }
    }

    /**
     * @param ServerModel[]|null $serverArray
     * @return Serverinfo
     */
    public function setServer(?array $serverArray): Serverinfo
    {
        if (is_array($serverArray)) {
            $this->server = $serverArray;
        }
        return $this;
    }

    /**
     * @param ServerModel|null $server
     * @return Serverinfo
     */
    public function addServer(?ServerModel $server): Serverinfo
    {
        if ($server) {
            $this->server[] = $server;
        }
        return $this;
    }
}
