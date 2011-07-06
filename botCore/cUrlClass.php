<?php
// Curl Class for navigate to sites

class cUrlClass{
    private $browser = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3';
    private $cookies_path = '';
    private $main_url = '';
    private $intf = '';
    
    public function setCookiesPath( $path )
    {
        $this->cookies_path = $path;   
    }
    
    public function setMainUrl( $url )
    {
        $this->main_url = $url;
    }
    
    public function setInterface( $intf )
    {
        $this->intf = $intf;
    }
    
    public function setBrowser( $browser )
    {
        $this->browser = $browser;
    }
    
    private function checkSettings()
    {
        if(strlen($this->browser) == 0 or strlen($this->cookies_path) == 0)
        {
            echo "cUrl class settings error !";
            return;
        }
    }

    public function goToPage($url)
    {
        $this->checkSettings();
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->main_url.$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_USERAGENT,$this->browser);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch,CURLOPT_COOKIEJAR,$this->cookies_path);
        curl_setopt($ch,CURLOPT_COOKIEFILE,$this->cookies_path);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 7);
	if(strlen($this->intf) > 0)
        {
            curl_setopt($ch,CURLOPT_INTERFACE,$this->intf);
        }
          return curl_exec($ch);  
     }

    public function sendPostData($url,$data,$rt = 0)	 
    {
        $this->checkSettings();
	$post_data = http_build_query($data);
        
        $ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$this->main_url.$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_USERAGENT,$this->browser);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
	curl_setopt($ch,CURLOPT_COOKIEJAR,$this->cookies_path);
	curl_setopt($ch,CURLOPT_COOKIEFILE,$this->cookies_path);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 7);
	if(strlen($this->intf) > 0)
        {
           curl_setopt($ch,CURLOPT_INTERFACE,$this->intf);
        }
        if($rt)
	   return curl_exec($ch); 
        else
           curl_exec($ch); 
    }
}

?>
