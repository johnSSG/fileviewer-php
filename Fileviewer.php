<?php
class Fileviewer {
	function __construct($apiKey, $doc = false, $permissions = false) {
		$this->apiKey = $apiKey;
		$this->doc = $doc;
		$this->baseUrl = 'https://viewer.filelabel.co/?';
		$this->url = 'https://viewer.filelabel.co/api/?';
		$this->permissions = $permissions;
		$this->auth = $this->auth();
		if($this->auth) :
			if(is_object($this->auth)) :
				$_SESSION['fileViewerToken'] = $this->auth->accessToken;
			else :
				$_SESSION['fileViewerToken'] = $this->auth;
			endif;
		endif;
	}
	
	public function auth() {		
		if(isset($_SESSION['fileViewerToken'])) :
			if($this->doc == false && $this->permissions == false) :
				if($_SESSION['fileViewerToken']) :				
					return $_SESSION['fileViewerToken'];
				endif;			
			endif;
		endif;
		$params = array(
			'apiKey' => $this->apiKey,
			'action' => 'auth'
		);
		if($this->doc) $params['url'] = $this->doc;
		if($this->permissions) $params['permissions'] = json_encode($this->permissions);
		return $this->getResponse($params);		
	}
	
    private function curl($url, $utf8 = true) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, null);
        curl_setopt($curl, CURLOPT_POST, FALSE);
        curl_setopt($curl, CURLOPT_HTTPGET, TRUE);        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $return = curl_exec($curl);
        curl_close($curl);
        return ($utf8) ? json_decode(utf8_encode($return))->output : json_decode($return)->output;        
    }
	
	public function decrypt($string) {
		return $this->x(base64_decode($string));
	}	

	public function encrypt($string) {
		return base64_encode($this->x($string));
	}	
    
    private function getResponse($params = false) {
        if($params) :
            $url = $this->url.http_build_query($params);
            $response = $this->curl($url);
            return (empty($response) ? false : $response);
        endif;
        return false;
    }
	
	public function load($doc = false, $encrypt = false) {
		if($doc) :
			if($encrypt) :
				return $this->baseUrl.'accessToken='.$_SESSION['fileViewerToken'].'&doc='.urlencode($this->encrypt($doc));
			else :
				return $this->baseUrl.'accessToken='.$_SESSION['fileViewerToken'].'&doc='.urlencode($doc);
			endif;
		else :
			return $this->baseUrl.'accessToken='.$_SESSION['fileViewerToken'];
		endif;
	}
	
	private function session() {
		if(!isset($_SESSION)) :
			session_start();
		endif;
	}

	public function x($string) {
		$key = $this->apiKey;
		$text = $string;
		$outText = '';
		for($i=0;$i<strlen($text);) :
			for($j=0;$j<strlen($key);$j++,$i++) :
				$outText .= @$text{$i} ^ $key{$j};
			endfor;
		endfor;
		return $outText;
	}	
}
?>
