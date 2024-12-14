<?php

namespace core\protection;

use pocketmine\event\Listener;
use pocketmine\event\block\{BlockPlaceEvent, BlockBreakEvent};
use pocketmine\player\Player;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Protection implements Listener{

    public function onPlace(BlockPlaceEvent $ev): void{
        $player = $ev->getPlayer();

        if (Server::getInstance()->isOp($player->getName())) {
            return;
        }else{
            $ev->cancel();
            $player->sendMessage(TextFormat::colorize("&6[&4!&6] &cYou can't place blocks"));
        }
    }

    public function onBreak(BlockBreakEvent $ev): void{
        $player = $ev->getPlayer();

        if (Server::getInstance()->isOp($player->getName())) {
            return;
        }else{
            $ev->cancel();
            $player->sendMessage(TextFormat::colorize("&6[&4!&6] &cYou can't break blocks"));
        }
    }

    public function onDamage(EntityDamageEvent $ev): void {
        $ev->cancel();
    }
}