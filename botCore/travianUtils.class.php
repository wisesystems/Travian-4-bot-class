<?php

abstract class travianUtils{
    
    protected function goToPage( $pageUrl )
    {
        $wb = new cUrlClass();
        
        if( defined('TRAVIAN_S_BROWSER') )
            $wb->setBrowser ( TRAVIAN_S_BROWSER );
        
        $wb->setCookiesPath( defined('TRAVIAN_S_CPATH') ? TRAVIAN_S_CPATH : '' );
        $wb->setInterface( defined('TRAVIAN_S_INTERFACE') ? TRAVIAN_S_INTERFACE : '' );
        $wb->setMainUrl( defined('TRAVIAN_S_MAINURL') ? TRAVIAN_S_MAINURL : '' );
        
        return $wb->goToPage( $pageUrl );
    }
    
    protected function sendPostData( $formAction , $formInputs , $returnPage = false )
    {
        $wb = new cUrlClass();
        
        if( defined('TRAVIAN_S_BROWSER') )
            $wb->setBrowser ( TRAVIAN_S_BROWSER );
        
        $wb->setCookiesPath( defined('TRAVIAN_S_CPATH') ? TRAVIAN_S_CPATH : '' );
        $wb->setInterface( defined('TRAVIAN_S_INTERFACE') ? TRAVIAN_S_INTERFACE : '' );
        $wb->setMainUrl( defined('TRAVIAN_S_MAINURL') ? TRAVIAN_S_MAINURL : '' );
        
        if($returnPage)
            return $wb->sendPostData ( $formAction , $formInputs , true );
        else
            $wb->sendPostData ( $formAction , $formInputs , false );
    }
    
    protected function getInputsFromForm( $formAction , $htmlPage )
    {
        global $html;
        $html->load( $htmlPage );
        if($html->find('form[action='.$formAction.']',0))
        {
            $formCodePart = $html->find('form[action='.$formAction.']',0)->innertext;
            $html->load( $formCodePart );
            $inputsArr = array();
            
            //Get all inputs from form
            foreach($html->find('input') as $input)
                    $inputsArr[$input->name] = $input->value;
            
            //Fix for submit button
            if($html->find('button[type=submit]',0))
                    $inputsArr[$html->find('button[type=submit]',0)->name] = $html->find('button[type=submit]',0)->value;
            
            return $inputsArr;
        }
        else
         echo "Error: No form with action = ".$formAction." !";
    }
    
    protected function getVillageInfo()
    {
        return json_decode( TRAVIAN_VI );
    }
}
