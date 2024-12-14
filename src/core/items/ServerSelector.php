<?php

namespace core\items;

use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\Listener;

class ServerSelector implements Listener {

    public function OnUse(PlayerItemUseEvent $ev): void{
        $player = $ev->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        if ($item->getCustomName() === TextFormat::colorize("&bServer Selector")){
            $player->sendMessage("Que gay!");
        }
    }
}