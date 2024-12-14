<?php

namespace core;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent, PlayerLoginEvent};
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;

class Events implements Listener {

    private $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    public function onLogin(PlayerLoginEvent $ev): void{
        $player = $ev->getPlayer();
        $player->teleport(new Vector3(0, 100, 0));
    }

    public function onJoin(PlayerJoinEvent $ev): void{
        $player = $ev->getPlayer();
        $playerName = $player->getName();

        $ev->setJoinMessage("");
        $joinMessage = $this->plugin->getConfig()->get("join-message", "&a[+] {player}");
        $joinMessage = str_replace("{player}", $playerName, $joinMessage);
        Server::getInstance()->broadcastMessage($joinMessage);
        $player->getInventory()->setItem(0, VanillaItems::CLOCK()->setCustomName(TextFormat::colorize("&bServer Selector")));
    }

    public function onQuit(PlayerQuitEvent $ev): void{
        $player = $ev->getPlayer();
        $playerName = $player->getName();

        $ev->setQuitMessage("");
        $quitMessage = $this->plugin->getConfig()->get("quit-message", "&c[-] {player}");
        $quitMessage = str_replace("{player}", $playerName, $quitMessage);
        Server::getInstance()->broadcastMessage($quitMessage);
        $player->getInventory()->clearAll();
    }
}