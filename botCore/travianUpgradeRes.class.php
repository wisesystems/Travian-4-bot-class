<?php

class travianUpgradeRes extends travianUtils{
    private $isOk = false;
    private $rId = 0;
    private $buildTime = 0;
    
    public function setResourceId( $rId )
    {
        $this->rId = $rId;
    }
    
    public function exec()
    {
        global $html;
        $html->load( $this->goToPage('build.php?id='.$this->rId) );
        if($html->find('button[class=build]',0))
        {
          //Get build time
          $time = $html->find('span[class=clocks]',0)->plaintext;
          $tmp = explode(':',$time);
          $this->buildTime = $tmp[0] * 3600 + $tmp[1] * 60 + $tmp[2];
            
          // Upgrade is posible  
          $actionOnClick = $html->find('button[class=build]',0)->onclick;
          $actionParts = explode('\'', $actionOnClick);
          
          //Get final link
          $linkToUpgrade = trim( str_replace( 'amp;' , '' , $actionParts[1] ) );
          $this->goToPage( $linkToUpgrade );
          $this->isOk = true;
        }
        else
            $this->isOk = false;
    }
    
    public function execSuccess()
    {
        return $this->isOk;
    }    
    
    public function getNextPosibleUpgrade()
    {
        global $html;
        $html->load( $this->goToPage('dorf1.php') );
        
        $np = 0;
        if($html->find('span[id=timer1]',0))
        {
            $time = $html->find('span[id=timer1]',0)->innertext;
            $te = explode(':',$time);
            $np = ($te[0] * 3600) + ($te[1] * 60) + $te[2];
        }
        
        return $np;
    }
    
    public function getBuildTime()
    {
        return $this->buildTime;
    }
}