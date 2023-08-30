<?php

namespace Modules\Minecraftserver\Mappers;

use Modules\Minecraftserver\Models\Server as MinecraftserverModel;
use Modules\Minecraftserver\Plugins\Serverinfo as ServerPlugin;

class Server extends \Ilch\Mapper
{
    /**
     * @param array $where
     * @param array $orderBy
     * @return MinecraftserverModel[]|null
     */
    public function getMincraftServer(array $where = [], array $orderBy = ['minecraftserver' => 'ASC', 'online' => 'DESC']): ?array
    {
        $resultArray = $this->db()->select('*')
            ->from('minecraftserver_status')
            ->where($where)
            ->order($orderBy)
            ->execute()
            ->fetchRows();

        if (empty($resultArray)) {
            return null;
        }

        $server = [];
        foreach ($resultArray as $serverRow) {
            $model = new MinecraftserverModel();
            $model->setId($serverRow['id'])
                ->setMinecraftserver($serverRow['minecraftserver'])
                ->setPort($serverRow['port'])
                ->setTimeout($serverRow['timeout'])
                ->setHostname($serverRow['hostname'])
                ->setOnline($serverRow['online'])
                ->setGametype($serverRow['gametype'])
                ->setGameId($serverRow['game_id'])
                ->setVersion($serverRow['version'])
                ->setPlugins($serverRow['plugins'])
                ->setMap($serverRow['map'])
                ->setNumplayers($serverRow['numplayers'])
                ->setMaxplayers($serverRow['maxplayers'])
                ->setHostport($serverRow['hostport'])
                ->setHostip($serverRow['hostip'])
                ->setSoftware($serverRow['software'])
                ->setPlayers($serverRow['players'])
                ->setServerpinginfo($serverRow['serverpinginfo'])
                ->setDescription($serverRow['description'])
                ->setUpdateTime($serverRow['updatetime']);
            $server[] = $model;
        }

        return $server;
    }

    /**
     * @param MinecraftserverModel $model
     * @return int
     */
    public function save(MinecraftserverModel $model): int
    {
        $fields = [
            'minecraftserver' => $model->getMinecraftserver(),
            'port' => $model->getPort(),
            'timeout' => $model->getTimeout(),
            'hostname' => $model->getHostname(),
            'online' => $model->getOnline(),
            'gametype' => $model->getGametype(),
            'game_id' => $model->getGameId(),
            'version' => $model->getVersion(),
            'plugins' => $model->getPlugins(),
            'map' => $model->getMap(),
            'numplayers' => $model->getNumplayers(),
            'maxplayers' => $model->getMaxplayers(),
            'hostport' => $model->getHostport(),
            'hostip' => $model->getHostip(),
            'software' => $model->getSoftware(),
            'players' => $model->getPlayers(),
            'serverpinginfo' => $model->getServerpinginfo(),
            'description' => $model->getDescription(),
            'updatetime' => $model->getUpdateTime(),
        ];

        if ($model->getId()) {
            $this->db()->update('minecraftserver_status')
            ->values($fields)
            ->where(['id' => $model->getId()])
            ->execute();
            return $model->getId();
        } else {
            return $this->db()->insert('minecraftserver_status')
            ->values($fields)
            ->execute();
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->db()->delete('minecraftserver_status')
            ->where(['id' => $id])
            ->execute();
    }

    /**
     * @param int $id
     * @return MinecraftserverModel|null
     */
    public function readById(int $id): ?MinecraftserverModel
    {
        $entrys = $this->getMincraftServer(['id' => $id]);

        if (!empty($entrys)) {
            return reset($entrys);
        }

        return null;
    }

    /**
     * @param string $minecraftserver
     * @return MinecraftserverModel|null
     */
    public function readByServer(string $minecraftserver): ?MinecraftserverModel
    {
        $entrys = $this->getMincraftServer(['minecraftserver' => $minecraftserver]);

        if (!empty($entrys)) {
            return reset($entrys);
        }

        return null;
    }

    /**
     * @param MinecraftserverModel|null $server
     * @return MinecraftserverModel[]|null
     */
    public function updateDataServer(?MinecraftserverModel $server = null): ?array
    {
        $api = new ServerPlugin();
        $date = new \Ilch\Date();
        $datenow = new \Ilch\Date($date->format("Y-m-d H:i:s", true));

        if (!$server) {
            $serverInDatabase = $this->getMincraftServer();
        } else {
            $serverInDatabase[] = $server;
        }

        if (!$serverInDatabase) {
            return null;
        }

        $api->setServer($serverInDatabase);
        $onlineServer = $api->getServerData();

        foreach ($serverInDatabase as $i => $server) {
            $server->setHostname("")
                ->setHostport(0)
                ->setHostip("")
                ->setOnline(false)
                ->setGametype("")
                ->setGameId("")
                ->setVersion("")
                ->setPlugins(serialize([]))
                ->setMap("")
                ->setNumplayers(0)
                ->setMaxplayers(0)
                ->setSoftware("")
                ->setPlayers(serialize([]))
                ->setServerpinginfo(serialize([]))
                ->setDescription('')
                ->setUpdateTime($datenow);

            foreach ($onlineServer ?? [] as $id => $obj) {
                if (strtolower($server->getMinecraftserver()) == strtolower($obj->getMinecraftserver())) {
                    if (!empty($obj->getServerInfo())) {
                        $server->setHostname($obj->getHostname())
                            ->setHostport($obj->getHostport())
                            ->setHostip($obj->getHostip())
                            ->setOnline($obj->getOnline())
                            ->setGametype($obj->getGametype())
                            ->setGameId($obj->getGameId())
                            ->setVersion($obj->getVersion())
                            ->setPlugins($obj->getPlugins())
                            ->setMap($obj->getMap())
                            ->setNumplayers($obj->getNumplayers())
                            ->setMaxplayers($obj->getMaxplayers())
                            ->setSoftware($obj->getSoftware())
                            ->setPlayers($obj->getPlayers())
                            ->setServerpinginfo($obj->getServerpinginfo());
                    }
                    $server->setDescription($obj->getDescription());

                    unset($onlineServer[$id]);
                    break;
                }
            }
            $id = $this->save($server);
            $server->setId($id);

            $serverInDatabase[$i] = $server;
        }
        return $serverInDatabase;
    }
}
