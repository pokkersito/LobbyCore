<?php

namespace core\items;

use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\Listener;
use FormAPI\FormAPI;
use FormAPI\Form;
use FormAPI\SimpleForm;

class ServerSelector implements Listener {

    public function OnUse(PlayerItemUseEvent $ev): void{
        $player = $ev->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        if ($item->getCustomName() === TextFormat::colorize("&bServer Selector")){
            $form = new SimpleForm(function ($player, $data) {
                if ($data === null) {
                    $player->sendMessage("Formulario cerrado.");
                    return;
                }
    
                switch ($data) {
                    case 0:
                        break;
                    case 1:
                        break;
                        break;
                }
            });
    
            $form->setTitle("§bServer Selector");
            $form->setContent("¡Hola, " . $player->getName() . "! Selecciona una opción:");
            $form->addButton("HCF");
            $form->addButton("UHC");
            $form->addButton("Salir");
            $player->sendForm($form);
        }
    }
}