<?php

namespace core;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent, PlayerLoginEvent, PlayerExhaustEvent, PlayerDeathEvent};
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
        $player->getInventory()->setItem(4, VanillaItems::CLOCK()->setCustomName(TextFormat::colorize("&bServer Selector")));
        $player->getInventory()->setItem(0, VanillaItems::DIAMOND_SWORD()->setCustomName(TextFormat::colorize("&4PvP")));
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

    public function onHunger(PlayerExhaustEvent $ev): void{
        $ev->cancel();
    }

    public function onDeath(PlayerDeathEvent $ev): void{
        $player = $ev->getPlayer();
        $ev->setKeepInventory(true);
    }
}