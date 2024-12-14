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

    public function onLogin(PlayerLoginEvent $ev): void{
        $player = $ev->getPlayer();
        $player->teleport(new Vector3(0, 100, 0));
    }

    public function onJoin(PlayerJoinEvent $ev): void{
        $player = $ev->getPlayer();

        $ev->setJoinMessage("");
        Server::getInstance()->broadcastMessage(TextFormat::GREEN . "[+] " . $player->getName());
        $player->getInventory()->setItem(0, VanillaItems::CLOCK()->setCustomName(TextFormat::colorize("&bServer Selector")));
    }

    public function onQuit(PlayerQuitEvent $ev): void{
        $player = $ev->getPlayer();

        $ev->setQuitMessage("");
        Server::getInstance()->broadcastMessage(TextFormat::RED . "[-] " . $player->getName());
        $player->getInventory()->clearAll();
    }
}