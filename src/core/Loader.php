<?php

namespace core;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use core\Events;
use core\items\ServerSelector;
use core\items\PvP;
use core\protection\Protection;
use ScoreAPI\{Scoreboard, ScoreboardScheduler, ScoreAPI};

class Loader extends PluginBase {

    private ScoreAPI $scoreapi;
    private $config;
    private static Loader $instance;

    public function getScoreAPI():ScoreAPI {
        return $this->scoreapi;
    }

    public function onLoad(): void {
        self::setInstance($this);
        $this->saveDefaultConfig();
        $this->scoreapi = new ScoreAPI();
        $config = $this->getInstance()->getConfig();
        $MOTD = $config->get('motd');
        $this->getServer()->getNetwork()->setName($MOTD);
    }

    public function onEnable(): void {
        $this->getLogger()->info(TextFormat::GREEN . "LobbyCore On!");
        $this->getScheduler()->scheduleRepeatingTask(new ScoreboardScheduler($this), 20);
        $this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new ServerSelector($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PvP($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Protection($this), $this);
    }

    public static function getInstance(): Loader
    {
        return self::$instance;
    }

    public static function setInstance(Loader $instance): void {
        self::$instance = $instance;
    }
}