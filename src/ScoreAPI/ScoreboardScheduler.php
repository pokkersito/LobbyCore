<?php

namespace ScoreAPI;

use pocketmine\Server;
use pocketmine\scheduler\Task;
use core\utils\ScoreboardBuilder;

class ScoreboardScheduler extends Task {

    public function onRun(): void {
        foreach(Server::getInstance()->getOnlinePlayers() as $player)(new ScoreboardBuilder())->build($player);
    }
}
