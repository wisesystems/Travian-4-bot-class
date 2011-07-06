<?php

class travianSendResources extends travianUtils{
    private $merchants = 0;
    private $merchCapacity = 0;
    private $r = array();
    private $to;
    private $formOneInputs = array();
    
    function travianSendResources()
    {
        global $html;
        $page = $this->goToPage('build.php?gid=17');
        $html->load( $page );
        $tmp = explode( ' ' , $html->find( 'div[class*=traderCount] div[class=boxes-contents]' , 0 )->innertext );
        $this->merchants = (int)$tmp[1];
        $this->merchCapacity = $html->find( 'td[class=max] a',0)->innertext;
        $this->formOneInputs = $this->getInputsFromForm( 'build.php' , $page );
    }
    
    public function setResNumber( $r1 , $r2 , $r3 , $r4 )
    {
        $this->r[1] = $r1;
        $this->r[2] = $r2;
        $this->r[3] = $r3;
        $this->r[4] = $r4;
    }
    
    public function setVillageCoords( $x , $y )
    {
        $this->to = array('x' => $x , 'y' => $y);
    }
    
    public function getTotalCapacity()
    {
        return $this->merchants * $this->merchCapacity;
    }
    
    public function exec()
    {
        $inputs = $this->formOneInputs;
        
        $inputs['r1'] = $this->r[1];
        $inputs['r2'] = $this->r[2];
        $inputs['r3'] = $this->r[3];
        $inputs['r4'] = $this->r[4];
        $inputs['x'] = $this->to['x'];
        $inputs['y'] = $this->to['y'];
        
        $inputsFin = $this->getInputsFromForm( 'build.php' , $this->sendPostData( 'build.php', $inputs , 1 ) );
        
        $this->sendPostData( 'build.php' , $inputsFin );
    }
    
}