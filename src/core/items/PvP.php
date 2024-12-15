<?php

namespace core\items;

use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\Listener;
use FormAPI\FormAPI;
use FormAPI\Form;
use FormAPI\SimpleForm;
use pocketmine\Server;
use pocketmine\command\ConsoleCommandSender;
use core\Loader;

class PvP implements Listener {

    private $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    public function OnUse(PlayerItemUseEvent $ev): void{
        $player = $ev->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $config = $this->plugin->getConfig();
        $worldName = $config->get('map-pvp');
        if ($item->getCustomName() === TextFormat::colorize("&4PvP")){
            $world = Server::getInstance()->getWorldManager()->getWorldByName($worldName);
            if ($world !== null) {
                $spawn = $world->getSafeSpawn();
                $player->teleport($spawn);
                $player->sendMessage(TextFormat::colorize("&cPvP &aActivado"));
            }
        }
    }
}
