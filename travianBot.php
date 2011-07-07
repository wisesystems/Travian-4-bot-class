<?php
/* Travian 4 Bot (Final version)
 * Author: x00bit (x00bit@gmail.com)
 */
error_reporting (E_ALL | E_STRICT);
ini_set("display_errors", 1); 

include("botCore/simple_html_dom.php");
include("botCore/cUrlClass.php");
include("botCore/travianUtils.class.php");
include("botCore/travianBot.class.php");
include("botCore/travianUpgradeRes.class.php");
include("botCore/travianAttack.class.php");
include("botCore/travianSendRes.class.php");
include("botCore/travianTroopsNum.class.php");

$html = new simple_html_dom;
?>