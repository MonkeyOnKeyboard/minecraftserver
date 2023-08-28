<?php

namespace Modules\Minecraftserver\Plugins;

use Modules\Minecraftserver\Libs\MinecraftPing;
use Modules\Minecraftserver\Libs\MinecraftServer;
use Modules\Minecraftserver\Models\Server as ServerModel;
use Modules\Minecraftserver\Mappers\Server as ServerMapper;

class Serverinfo {
    
    private $server = [];
    private $dataServer = [];
    private $Info =[];
    
    
    public function getServerData(){

        if (count($this->server) > 0) {
            foreach ($this->server as $server) {
                    $minecraftserver = $server->getMinecraftserver();
                    
                    $serverdata = new MinecraftServer($server->getMinecraftserver(), $server->getPort(), $server->getTimeout());
                    try {
                        $Query = new MinecraftPing($server->getMinecraftserver(), $server->getPort(), $server->getTimeout());
                        if (isset($Query)) {
                            $Info = $Query->Query( );
                            if( $Info === false )
                            {
                                
                                
                                $Query->Close( );
                                $Query->Connect( );
                                $Info = $Query->QueryOldPre17( );
                                
                            }
                            
                        } 
                    } catch (\Throwable $ignored) {
                        // Auf die verschiedenen Exceptions reagieren.
                        // Die verschiedenen MinecraftPingExceptions kannst du durch die "Message" oder andere Eigenschaften unterscheiden.
                        //echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
                    } finally {
                        // Verbindung trennen, aufräumen, ...
                        
                        if(isset($Query))
                        {
                            $Query->Close();
                        } else {
                            
                            $Info = [];
                            
                        }
                    }

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
                    ->setOnline($serverdata->online)
                    ->setPlayers(serialize($serverdata->players))
                    ->setServerInfo($serverdata->getInfoArray())
                    ->setServerpinginfo(serialize($Info));
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
