<?php

namespace Modules\Minecraftserver\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'minecraftserver',
        'version' => '1.0.1',
        'icon_small' => 'fa-server',
        'author' => 'Markus | MonkeyOnKeyboard',
        'languages' => [
            'de_DE' => [
                'name' => 'Minecraftserver-status',
                'description' => 'Hier können Minecraftserver verwaltet und deren Status ausgegeben werden.',
            ],
            'en_EN' => [
                'name' => 'Minecraftserver-status',
                'description' => 'Here you can manage Minecraftserver and there Status',
            ],
        ],
        'boxes' => [
            'minecraftserver' => [
                'de_DE' => [
                    'name' => 'Minecraftserver'
                ],
                'en_EN' => [
                    'name' => 'Minecraftserver'
                ],
            ],
        ],
        'ilchCore' => '2.1.52',
        'phpVersion' => '7.3',
    ];

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());

        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->set('minecraftserver_requestEveryPageCall', '0')
            ->set('minecraftserver_showOffline', '0');
    }

    public function uninstall()
    {
        $this->db()->drop('minecraftserver_status', true);
        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->delete('minecraftserver_requestEveryPageCall')
            ->delete('minecraftserver_showOffline');
    }

    public function getInstallSql(): string
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_minecraftserver_status` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `minecraftserver` VARCHAR(255) NOT NULL,
            `port` INT(5) NOT NULL,
            `timeout` INT(2) NOT NULL,
            `hostname` VARCHAR(255) NOT NULL,
            `online` INT(1) NULL,
            `gametype` VARCHAR(255) NULL,
            `game_id` VARCHAR(255) NULL,
            `version` VARCHAR(255) NULL,
            `plugins` LONGTEXT NULL,
            `map` VARCHAR(255) NULL,
            `numplayers` INT(6) NULL,
            `maxplayers` INT(6) NULL,
            `hostport` INT(5) NULL,
            `hostip` VARCHAR(255) NULL,
            `software` VARCHAR(255) NULL,
            `players` LONGTEXT NULL,
            `serverpinginfo` LONGTEXT NOT NULL,
            `description` LONGTEXT NOT NULL,
            `updatetime` datetime NOT NULL,
            PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;';
    }

    public function getUpdate(string $installedVersion): string
    {
        switch ($installedVersion) {
            case "1.0.0":
                $this->db()->query('ALTER TABLE `[prefix]_minecraftserver_status` ADD `description` LONGTEXT NOT NULL AFTER `serverpinginfo`;');
                $this->db()->query('ALTER TABLE `[prefix]_minecraftserver_status` ADD `updatetime` datetime NOT NULL AFTER `description`;');
        }

        return '"' . $this->config['key'] . '" Update-function executed.';
    }
}
