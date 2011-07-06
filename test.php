<?php

include('travianBot.php');

$travianBot = new travianBot();
$travianBot->setCookiesPath('/tmp/cookiest.txt');
$travianBot->setMainUrl('http://tx3.travian.com.au/');
$travianBot->setLoginData( 'x00bit', 'sxsvsdha17b' );

if(!$travianBot->isLoged())
        $travianBot->loginToTravian();

/*
$upgrade = new travianUpgradeRes;
$upgrade->setResourceId(12);
$upgrade->exec();
echo $upgrade->getBuildTime()."\n";
*/
/*
$attack = new travianAttack;
$attack->setAttackType( travianAttack::REINFM );
$attack->setCoordonates( '-85' , '70' );
$attack->setTroops(0,0,0,0,0,23);
$attack->exec();
*/

$send = new travianSendResources; echo $send->getTotalCapacity();
$send->setResNumber(1, 1, 1, 1);
$send->setVillageCoords(-85, 70);
//$send->exec();

/*
$troops = new travianTroopsNum();
print_r( $troops->get() );
*/
 