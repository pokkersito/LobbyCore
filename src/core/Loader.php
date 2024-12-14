<?php

namespace core;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use core\Events;
use core\items\ServerSelector;
use core\protection\Protection;

class Loader extends PluginBase {

    private $config;
    protected static $instance;

    public function onLoad(): void {
    }

    public function onEnable(): void {
        $this->getLogger()->info(TextFormat::GREEN . "LobbyCore On!");
        $this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new ServerSelector(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Protection(), $this);
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->setMotd();
    }

    private function setMotd(): void {
        $motd = $this->config->get("motd", "§bServidor HCF");

        $serverPropertiesPath = $this->getServer()->getDataPath() . "server.properties";
        
        if (file_exists($serverPropertiesPath)) {
            $properties = parse_ini_file($serverPropertiesPath);
            $properties["motd"] = $motd;
            $this->writeProperties($serverPropertiesPath, $properties);
    }
}

    private function writeProperties(string $path, array $properties): void {
        $content = "";
        foreach ($properties as $key => $value) {
            $content .= $key . "=" . $value . "\n";
        }
        file_put_contents($path, $content);
    }

    public static function getInstance(): Loader {
        return self::$instance;
    }
}