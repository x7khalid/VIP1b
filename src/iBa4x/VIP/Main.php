<?php
namespace iBa4x\VIP;
# this plugin by iBa4x
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;
class Main extends PluginBase implements Listener{
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(TextFormat::GREEN . "By iBa4x");
    @mkdir($this->getDataFolder());
  }
  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
    switch($cmd->getName()){
    	case "vip1b":
    		if($sender->isOp()){
    			if(isset($args[0])){
    				switch($args[0]){
    					case "pos1":
    						$x = $sender->getFloorX();
    						$y = $sender->getFloorY();
    						$z = $sender->getFloorZ();
    						$this->getConfig()->set("x1", $x);
    						$this->getConfig()->set("y1", $y);
    						$this->getConfig()->set("z1", $z);
    						$this->getConfig()->save();
    						$sender->sendMessage(TextFormat::GREEN."- Pos1 set to: ($x, $y, $z)");
    					return true;
    					case "pos2":
    						$x = $sender->getFloorX();
    						$y = $sender->getFloorY();
    						$z = $sender->getFloorZ();
    						$this->getConfig()->set("x2", $x);
    						$this->getConfig()->set("y2", $y);
    						$this->getConfig()->set("z2", $z);
    						$this->getConfig()->save();
    						$sender->sendMessage(TextFormat::GREEN."- Pos2 set to: ($x, $y, $z)");
    					return true;
    					case "permission":
    						$sender->sendMessage(TextFormat::YELLOW."- vip1b.area.vip");
    					return true;
    				}
    			}
    		}
    	}
  }
  public function isInside(Vector3 $pp, Vector3 $p1, Vector3 $p2){
	return ((min($p1->getX(),$p2->getX()) <= $pp->getX()) && (max($p1->getX(),$p2->getX()) >= $pp->getX()) && (min($p1->getY(),$p2->getY()) <= $pp->getY()) && (max($p1->getY(),$p2->getY()) >= $pp->getY()) && (min($p1->getZ(),$p2->getZ()) <= $pp->getZ()) && (max($p1->getZ(),$p2->getZ()) >= $pp->getZ()));
  }
  public function onMove(PlayerMoveEvent $event){
	$player = $event->getPlayer();
	$x1 = $this->getConfig()->get("x1");
	$z1 = $this->getConfig()->get("z1");
	$y1 = $this->getConfig()->get("y1");
	$x2 = $this->getConfig()->get("x2");
	$y2 = $this->getConfig()->get("y2");
	$z2 = $this->getConfig()->get("z2");
	if($this->isInside($player,new Vector3($x1,$y1,$z1),new Vector3($x2,$y2,$z2))){
		if(!$player->hasPermission("vip1b.area.vip")){
			$spawn = $this->getServer()->getDefaultLevel()->getSafeSpawn();
			$player->teleport(new Vector3($spawn->getX(),$spawn->getY(),$spawn->getZ()));
			$player->sendMessage(TextFormat::RED."You do not have permission to join area");
		}
	}
  }
  public function onDisable(){
    $this->getConfig()->save();
  }
}
