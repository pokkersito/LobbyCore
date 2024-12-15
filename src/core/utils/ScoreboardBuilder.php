<?php

namespace core\utils;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use IvanCraft623\RankSystem\RankSystem;
use core\Loader;

class ScoreboardBuilder {

    public function build(Player $player): void {
        
        $config = Loader::getInstance()->getConfig();
        $sb = Loader::getInstance()->getScoreAPI();

        $sb->removeScoreboard($player);
        $sb->newScore($player, TextFormat::colorize($config->get('scoreboard')['title']));
        $ip = $config->get('IP');
        $rank = RankSystem::getInstance()->getSessionManager()->get($player)->getHighestRank()->getName();

        $lines = "";

        foreach($config->get('scoreboard')['lines'] as $score => $line){
            $sb->setLine($player, ($score +1), TextFormat::colorize(str_replace([
                "{name}", 
                "{ping}", 
                "{players}", 
                "{ip}", 
                "{rank}", 
                "{line}", 
            ], [    
                $player->getName(), 
                $player->getNetworkSession()->getPing(), 
                count(Server::getInstance()->getOnlinePlayers()), 
                $ip, 
                $rank, 
                $lines, 
            ], $line)));
        }
    }
}