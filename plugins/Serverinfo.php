<?php

namespace Modules\Minecraftserver\Plugins;

use Modules\Minecraftserver\Libs\MinecraftPing;
use Modules\Minecraftserver\Libs\MinecraftServer;
use Modules\Minecraftserver\Models\Server as ServerModel;
use Modules\Minecraftserver\Mappers\Server as ServerMapper;

class Serverinfo {
    
    private $server = [];
    private $dataServer = [];
    
    
    public function getServerData(){

        echo "<hr>";
        echo count($this->server);
        echo "<hr>";
        
        if (count($this->server) > 0) {
            foreach ($this->server as $server) {
                    $minecraftserver = $server->getMinecraftserver();
                    
                    
                    
                    
                    $serverdata = new MinecraftServer($server->getMinecraftserver(), $server->getPort(), $server->getTimeout());
                    
                    /*
                    $Query = new MinecraftPing($server->getMinecraftserver(), $server->getPort(), $server->getTimeout());
                    $Info = $Query->Query( );
                    if( $Info === false )
                    {
                        
                        
                        $Query->Close( );
                        $Query->Connect( );
                        $Info = $Query->QueryOldPre17( );
                        
                    }
                    */
                    $model = new ServerModel();
                    $model->setMinecraftserver($minecraftserver)
                    ->setHostname($serverdata->hostname)
                    ->setGametype($serverdata->gametype)
                    ->setGame_id($serverdata->game_id)
                    ->setVersion($serverdata->version)
                    ->setPlugins(serialize($serverdata->plugins))
                    ->setMap($serverdata->map)
                    ->setNumplayers($serverdata->numplayers)
                    ->setMaxplayers($serverdata->maxplayers)
                    ->setHostip($serverdata->hostip)
                    ->setHostport($serverdata->hostport)
                    ->setSoftware($serverdata->software)
                    ->setOnline($serverdata->online);
                    if (!$serverdata->players) {
                        $model->setPlayers(NULL);
                    } else {
                        $model->setPlayers(serialize($serverdata->players));
                    }
                    
                    /*
                    if ( $Info !== false )
                    {
                         $model->setServerpinginfo(serialize($Info));
                    }
                    */
                    $this->dataServer[] = $model;
                    
            }
            return $this->dataServer;
            
        } else {
            return null;
        }
        
    }
 
    public function setServer($serverArray)
    {
        if (is_array($serverArray)) {
            $this->server = $serverArray;
        }
        return $this;
    }
    
    public function addServer(string $server)
    {
        if ($server) {
            $this->server[] = $server;
        }
        return $this;
    }
}
