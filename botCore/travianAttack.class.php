<?php

class travianAttack extends travianUtils{
    private $troops = array();
    private $vx = 0;
    private $vy = 0;
    private $atackType;
    const REINFM = 2;
    const NORMAL = 3;
    const RAID = 4;
    
    public function setCoordonates( $x , $y )
    {
        $this->vx = $x;
        $this->vy = $y;
    }
    
    public function setTroops( $t1 = '' , $t2 = '' , $t3 = '' , $t4 = '' , $t5 = '' , $t6 = '' , $t7 = '' , $t8 = '' , $t9 = '' , $t10 = '' , $t11 = '' )
    {
        $this->troops['t1'] = $t1;
        $this->troops['t2'] = $t2;
        $this->troops['t3'] = $t3;
        $this->troops['t4'] = $t4;
        $this->troops['t5'] = $t5;
        $this->troops['t6'] = $t6;
        $this->troops['t7'] = $t7;
        $this->troops['t8'] = $t8;
        $this->troops['t9'] = $t9;
        $this->troops['t10'] = $t10;
        $this->troops['t11'] = $t11;
    }
    
    public function setAttackType( $aType )
    {
        $this->atackType = $aType;
    }
    
    public function exec()
    {
        global $html;
        
        $inputs =  $this->getInputsFromForm( 'a2b.php' , $this->goToPage('a2b.php') );
        $inputs['x'] = $this->vx;
        $inputs['y'] = $this->vy;
        $inputs['t1'] = $this->troops['t1'];
        $inputs['t2'] = $this->troops['t2'];
        $inputs['t3'] = $this->troops['t3'];
        $inputs['t4'] = $this->troops['t4'];
        $inputs['t5'] = $this->troops['t5'];
        $inputs['t6'] = $this->troops['t6'];
        $inputs['t7'] = $this->troops['t7'];
        $inputs['t8'] = $this->troops['t8'];
        $inputs['t9'] = $this->troops['t9'];
        $inputs['t10'] = $this->troops['t10'];
        $inputs['t11'] = $this->troops['t11'];
        $inputs['c'] = $this->atackType;

        $pageDo = $this->sendPostData('a2b.php' , $inputs , 1);
        $nextInputs = $this->getInputsFromForm('a2b.php' , $pageDo );

        $this->sendPostData('a2b.php' , $nextInputs);
    }
    
    public function getDataFromA2b()
    {
        global $html;
        
        //Array with resuls
        $res = array( 'tm' => array() , 'fm' => array() );
        
        // Data of asistances
        $html->load( $this->goToPage( 'build.php?id=39&k' ) );
        foreach($html->find('table[class=troop_details inReturn]') as $tableAs)
        {
            //Get id of the village
            $getId = explode( '=' , $tableAs->find('a',1)->href );
            
            //Set a new coords class
            $coords = new villageCoords( $getId[1] );
            
            //GetId
            if($coords->cExists())
            {
                $resC = $coords->getCoords();
            }
            else
            {
                $tmp = $this->extractVillageCoords( $this->goToPage( $tableAs->find('a',1)->href ) );
                $resC = $tmp[0].'|'.$tmp[1];
                $coords->setCoords( $tmp[0] , $tmp[1] );
            }
            
            //Set the result
            $res['tm'][] = $resC;
        }
        
        // Data of atacks : normal
        foreach($html->find('table[class=troop_details outAttack]') as $tableAt)
        {
            //Get id of the village
            $getId = explode( '=' , $tableAt->find('a',1)->href );
            
            //Set a new coords class
            $coords = new villageCoords( $getId[1] );
            
            //GetId
            if($coords->cExists())
            {
                $resC = $coords->getCoords();
            }
            else
            {
                $tmp = $this->extractVillageCoords( $this->goToPage( $tableAt->find('a',1)->href ) );
                $resC = $tmp[0].'|'.$tmp[1];
                $coords->setCoords( $tmp[0] , $tmp[1] );
            }
            
            //Set the result
            $res['fm'][] = $resC;
        }
        
        // Data of atack : speed
        foreach($html->find('table[class=troop_details outRaid]') as $tableAt)
        {
            //Get id of the village
            $getId = explode( '=' , $tableAt->find('a',1)->href );
            
            //Set a new coords class
            $coords = new villageCoords( $getId[1] );
            
            //GetId
           // if($coords->cExists())
           // {
           //    $resC = $coords->getCoords();
           // }
           // else
           // {
                $tmp = $this->extractVillageCoords( $this->goToPage( $tableAt->find('a',1)->href ) );
                $resC = $tmp[0].'|'.$tmp[1];
                $coords->setCoords( $tmp[0] , $tmp[1] );
           // }
            
            //Set the result
            $res['fm'][] = $resC;
        }
        
        return $res;
                
    }
    
    private function extractVillageCoords( $htmlPage )
    {
        $htmlParse = new simple_html_dom;
        $htmlParse->load( $htmlPage );
        $villageX = str_replace( '(' , '' , trim($htmlParse->find('span[class=coordinateX]',0)->innertext) );
        $villageY = str_replace( ')' , '' , trim($htmlParse->find('span[class=coordinateY]',0)->innertext) );
        return array($villageX , $villageY); 
    }
}