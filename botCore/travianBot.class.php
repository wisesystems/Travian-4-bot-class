<?php

/* Constants:
 * TRAVIAN_S_MAINURL ( travian server main url )
 * TRAVIAN_S_INTERFACE ( linux internet interface )
 * TRAVIAN_S_BROWSER - curl browser imitation (user-agent)
 * TRAVIAN_S_CPATH - cookies path
 */

class travianBot extends travianUtils{
    private $villageInfo;
    private $villageId;
    protected $tUsername = '';
    protected $tPassword = '';

    function travianBot( $villageId = 0 )
    {
        $this->villageId = $villageId;
    }
    
    public function setCookiesPath( $cPath )
    {
        define( 'TRAVIAN_S_CPATH' , $cPath );
    }
    
    public function setInterface( $interface )
    {
        define( 'TRAVIAN_S_INTERFACE' , $interface );
    }
    
    public function setUserAgent( $uAgent )
    {
        define( 'TRAVIAN_S_BROWSER' , $uAgent );
    }
    
    public function setMainUrl( $mUrl )
    {
        define( 'TRAVIAN_S_MAINURL' , $mUrl );
    }
    
    public function setLoginData( $tUsername , $tPassword )
    {
        $this->tUsername = $tUsername;
        $this->tPassword = $tPassword;
    }
    
    public function isLoged()
    {
        global $html;
        $loginPage = $this->goToPage('dorf1.php');
        $html->load( $loginPage );
        if($html->find('a[href=logout.php]',0))
        {
            // isLoged == true
            $this->changeVillage($this->villageId);
            $this->_getVillageInfo( $this->goToPage('dorf1.php') );
            $this->makeVillageInfoGlobal();
             return true;
        }
        else
            return false;
    }
    
    public function loginToTravian()
    {
        global $html;
        $loginInputs = $this->getInputsFromForm( 'dorf1.php' , $this->goToPage('login.php') );
        $loginInputs['name'] = $this->tUsername;
        $loginInputs['password'] = $this->tPassword;
        
        $pageAfterLogin = $this->sendPostData( 'dorf1.php' , $loginInputs , 1);
        $this->changeVillage( $this->villageId );
        $this->_getVillageInfo( $this->goToPage('dorf1.php') ); 
        $this->makeVillageInfoGlobal();
    }
    
    private function makeVillageInfoGlobal()
    {
        define( 'TRAVIAN_VI' , json_encode($this->villageInfo) );
    }
    
    private function changeVillage( $villageId )
    {
        if($this->villageId > 0)
          $this->goToPage( 'dorf1.php?newdid='.$villageId );
    }
    
    private function _getVillageInfo( $htmlPage )
    {
        global $html;
        $html->load( $htmlPage );
        // Production per hour
        $this->villageInfo['phLumber'] = trim($html->find('table[id=production] tbody td[class=num]',0)->innertext);
        $this->villageInfo['phClay'] = trim($html->find('table[id=production] tbody td[class=num]',1)->innertext);
        $this->villageInfo['phIron'] = trim($html->find('table[id=production] tbody td[class=num]',2)->innertext);
        $this->villageInfo['phCrop'] = trim($html->find('table[id=production] tbody td[class=num]',3)->innertext);
        
        // Nr. of resources and maximum capacity
        $lumber = explode('/',trim($html->find('span[id=l1]',0)->innertext));
        $this->villageInfo['lumber'] = $lumber[0];
        $this->villageInfo['maxLumber'] = $lumber[1];
        
        $clay = explode('/',trim($html->find('span[id=l2]',0)->innertext));  
        $this->villageInfo['clay'] = $clay[0];
        $this->villageInfo['maxClay'] = $clay[1];
        
        $iron = explode('/',trim($html->find('span[id=l3]',0)->innertext));
        $this->villageInfo['iron'] = $iron[0];
        $this->villageInfo['maxIron'] = $iron[1];
        
        $crop = explode('/',trim($html->find('span[id=l4]',0)->innertext));
        $this->villageInfo['crop'] = $crop[0];
        $this->villageInfo['maxCrop'] = $crop[1];
        
        // Get info about troops
        $this->villageInfo['troops'] = $this->getTroopsInfo( $htmlPage );
    }
    
    private function getTroopsInfo( $htmlPage )
    {
        global $html;
        $html->load( $htmlPage );
        
        $result = array();
        $tmp = array();
        
        foreach($html->find('table[id=troops] tr') as $tableTr)
        {
            //If is the tr with neccesary info
            if($tableTr->find('td[class=un]'))
            {
                //Put the info into the temporary array
                $tmp[$tableTr->find('td[class=ico] img',0)->class] = trim( $tableTr->find('td[class=num]',0)->innertext );
            }
        }
     
        //Put info to the final array
        $result['t1'] = array_key_exists( 'unit u11' , $tmp ) ? $tmp['unit u11'] : 0;
        $result['t2'] = 0;
        $result['t3'] = 0;
        $result['t4'] = array_key_exists( 'unit u14' , $tmp ) ? $tmp['unit u14'] : 0;
        $result['t5'] = array_key_exists( 'unit u15' , $tmp ) ? $tmp['unit u15'] : 0;
        $result['t6'] = 0;
        $result['t7'] = 0;
        $result['t8'] = 0;
        $result['t9'] = 0;
        $result['t10'] = 0;
        $result['t11'] = 0;
        
        return $result;
    }
    
    public function getVillageInfo()
    {
        return $this->villageInfo;
    }
    
}
