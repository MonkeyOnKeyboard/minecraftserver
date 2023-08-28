<?php

namespace Modules\Minecraftserver\Mappers;

use \Modules\Minecraftserver\Models\Server as MinecraftserverModel;
use \Modules\Minecraftserver\Plugins\Serverinfo as ServerPlugin;
use MongoDB\Driver\ServerApi;

class Server extends \Ilch\Mapper
{

    public function getMincraftServer($where = [], $orderBy = ['minecraftserver' => 'ASC', 'online' => 'DESC'])
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
                ->setTimeouit($serverRow['timeout'])
                ->setHostname($serverRow['hostname'])
                ->setOnline($serverRow['online'])
                ->setGametype($serverRow['gametype'])
                ->setGame_id($serverRow['game_id'])
                ->setVersion($serverRow['version'])
                ->setPlugins($serverRow['plugins'])
                ->setMap($serverRow['map'])
                ->setNumplayers($serverRow['numplayers'])
                ->setMaxplayers($serverRow['maxplayers'])
                ->setHostport($serverRow['hostport'])
                ->setHostip($serverRow['hostip'])
                ->setSoftware($serverRow['software'])
                ->setPlayers($serverRow['players'])
                ->setServerpinginfo($serverRow['serverpinginfo']);
                $server[] = $model;
        }

        return $server;


    }
    
    public function save(MinecraftserverModel $model)
    {
        $fields = [
            'minecraftserver' => $model->getMinecraftserver(),
            'port' => $model->getPort(),
            'timeout' => $model->getTimeout(),
            'hostname' => $model->getHostname(),
            'online' => $model->getOnline(),
            'gametype' => $model->getGametype(),
            'game_id' => $model->getGame_id(),
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
        ];
        
        if ($model->getId()) {
            $return = $this->db()->update('minecraftserver_status')
            ->values($fields)
            ->where(['id' => $model->getId()])
            ->execute();
        } else {
            $return = $this->db()->insert('minecraftserver_status')
            ->values($fields)
            ->execute();
        }
        return $return;
    }
   

    public function delete(int $id)
    {
        $this->db()->delete('minecraftserver_status')
            ->where(['id' => $id])
            ->execute();
    }

    public function readById(int $id)
    {
        $entrys = $this->getMincraftServer(['id' => (int) $id]);

        if (!empty($entrys)) {
            return reset($entrys);
        }
        
        return null;
    }

    public function readByServer(string $minecraftserver)
    {
        $entrys = $this->getMincraftServer(['minecraftserver' => $minecraftserver]);

        if (!empty($entrys)) {
            return reset($entrys);
        }
        
        return null;
    }

    
    public function updateDataServer(MinecraftserverModel $server = null)
    {
        $api = new ServerPlugin();
        
        if (!$server) {
            $serverInDatabase = $this->getMincraftServer();
        } else {
            $serverInDatabase[] = $server;
        }
        
        if (!$serverInDatabase){
            return null;
        }
        
        $api->setServer($serverInDatabase);
        $onlineServer = $api->getServerData();
        
        foreach ($serverInDatabase as $id => $server) {
            
            $server->setHostname("")
            ->setHostport(0)
            ->setHostip("")
            ->setOnline(0)
            ->setGametype("")
            ->setGame_id("")
            ->setVersion("")
            ->setPlugins(serialize(array()))
            ->setMap("")
            ->setNumplayers(0)
            ->setMaxplayers(0)
            ->setSoftware("")
            ->setPlayers(serialize(array()))
            ->setServerpinginfo(serialize(array()));
            
            foreach ($onlineServer ?? [] as $id => $obj) {
                             
                if (strtolower($server->getMinecraftserver()) == strtolower($obj->getMinecraftserver())) {
                    
                    if (empty($obj->getServerInfo())) {
                        $server->setMinecraftserver($obj->getMinecraftserver())
                        ->setPort($obj->getPort())
                        ->setTimeouit($obj->getTimeout());
                        
                        $server->setHostname("")
                        ->setHostport(0)
                        ->setHostip("")
                        ->setOnline(0)
                        ->setGametype("")
                        ->setGame_id("")
                        ->setVersion("")
                        ->setPlugins(serialize(array()))
                        ->setMap("")
                        ->setNumplayers(0)
                        ->setMaxplayers(0)
                        ->setSoftware("")
                        ->setPlayers(serialize(array()))
                        ->setServerpinginfo(serialize(array()));
                    } else {
                    
                        $server->setMinecraftserver($obj->getMinecraftserver());
                        $server->setHostname($obj->getHostname())
                        ->setHostport($obj->getHostport())
                        ->setHostip($obj->getHostip())
                        ->setOnline($obj->getOnline())
                        ->setGametype($obj->getGametype())
                        ->setGame_id($obj->getGame_id())
                        ->setVersion($obj->getVersion())
                        ->setPlugins($obj->getPlugins())
                        ->setMap($obj->getMap())
                        ->setNumplayers($obj->getNumplayers())
                        ->setMaxplayers($obj->getMaxplayers())
                        ->setSoftware($obj->getSoftware())
                        ->setPlayers($obj->getPlayers())
                        ->setServerpinginfo($obj->getServerpinginfo());
                    
                    }
                    
                    unset($onlineServer[$id]);
                    break;
                }
            }
            $serverInDatabase[$id] = $server;
            
            $this->save($server);
        }
        return $serverInDatabase;
    }

}
