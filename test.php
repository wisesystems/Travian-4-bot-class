<?php

include('travianBot.php');

$travianBot = new travianBot();
$travianBot->setCookiesPath('/tmp/cookiest.txt');
$travianBot->setMainUrl('http://.travian./');
$travianBot->setLoginData( 'x00bit', '' );

if(!$travianBot->isLoged())
        $travianBot->loginToTravian();

/*
$upgrade = new travianUpgradeRes;
$upgrade->setResourceId(7);
$upgrade->exec();
var_dump($upgrade->execSuccess());
*/
/*
$attack = new travianAttack;
$attack->setAttackType( travianAttack::REINFM );
$attack->setCoordonates( '-85' , '70' );
$attack->setTroops(0,0,0,0,0,23);
$attack->exec();
*/
/*
$send = new travianSendResources;
$send->setResNumber(1, 1, 1, 1);
$send->setVillageCoords(-85, 70);
$send->exec();
*/
