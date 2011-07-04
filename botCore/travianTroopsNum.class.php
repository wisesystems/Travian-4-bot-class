<?php

/* This class work only for english servers */

class travianTroopsNum extends travianUtils{
    private $tNum = array();
    
    public function get()
    {
        if(count($this->tNum) == 0)
                $this->getData();
        
         return $this->tNum;
    }
    
    private function getData()
    {
        global $html;
        $html->load( $this->goToPage('build.php?id=39') );
        
        $tmp = array('t1' => 0 ,'t2' => 0,'t3' => 0,'t4' => 0,'t5' => 0,'t6' => 0,'t7' => 0,'t8' => 0,'t9' => 0,'t10' => 0,'t11' => 0);
        foreach($html->find('table[class=troop_details]') as $table)
        {
            $tName = $table->find('td[class=troopHeadline]',0)->plaintext;
            if($tName == 'Own troops' or strpos( $tName , 'Reinforcement for' ) !== false)
            {
                $tmp['t1'] += $table->find('tr',2)->find('td[class*=unit]',0)->innertext;
                $tmp['t2'] += $table->find('tr',2)->find('td[class*=unit]',1)->innertext;
                $tmp['t3'] += $table->find('tr',2)->find('td[class*=unit]',2)->innertext;
                $tmp['t4'] += $table->find('tr',2)->find('td[class*=unit]',3)->innertext;
                $tmp['t5'] += $table->find('tr',2)->find('td[class*=unit]',4)->innertext;
                $tmp['t6'] += $table->find('tr',2)->find('td[class*=unit]',5)->innertext;
                $tmp['t7'] += $table->find('tr',2)->find('td[class*=unit]',6)->innertext;
                $tmp['t8'] += $table->find('tr',2)->find('td[class*=unit]',7)->innertext;
                $tmp['t9'] += $table->find('tr',2)->find('td[class*=unit]',8)->innertext;
                $tmp['t10'] += $table->find('tr',2)->find('td[class*=unit]',9)->innertext;
                $tmp['t11'] += $table->find('tr',2)->find('td[class*=unit]',10)->innertext;
            }
        }
        
        $this->tNum = $tmp;
    }
    
}