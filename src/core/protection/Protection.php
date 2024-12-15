<?php

namespace core\protection;

use pocketmine\event\Listener;
use pocketmine\event\block\{BlockPlaceEvent, BlockBreakEvent};
use pocketmine\player\Player;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use core\Loader;

class Protection implements Listener{

    private $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

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
        $config = $this->plugin->getConfig();
        $worldName = $config->get('map-pvp');
        if ($ev->getEntity()->getWorld()->getFolderName() === $worldName) {
           return;
        }else{
            $ev->cancel();
        }
    }
}