<?php
class Scrappers_project_AASTU_morguefile {
    private $app_id = '';
    private $app_secret = '';
    
	function __construct($app_id, $app_secret) {
		if(!function_exists('curl_init')){
			throw new Exception('Curl is required for morguefile API');
		}
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
	}
	
	public function call($parms, $method='json'){
		$o = $this->cleanParamString($parms);
		if(!empty($o)){
		
			if($method!='json' && $method!='xml'){
				$method = 'json';
			}
			/* create the signature */
			$sig = hash_hmac("sha256", $o['str'], $this->app_secret);
			/* create the api call */
			$c = curl_init ('https://morguefile.com/api/' . $o['uri'] . '.'.$method );
			curl_setopt ($c, CURLOPT_POST, true);
			curl_setopt ($c, CURLOPT_POSTFIELDS, 'key='.$this->app_id.'&sig='.$sig);
			curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
			$page = curl_exec ($c);
			curl_close ($c);			
			if(!empty($page)){
				if($method=='json'){
					$data = json_decode($page);
				} else {
					$data = ($page);
				}
				return $data;
			} else {
				throw new Exception(curl_error($ch));
			}
		} else {
			throw new Exception('Malformed string');
		}
	}
	
	private function cleanParamString($parms){
		/* clean up the url string to avoid errors */
		$parms = trim(strtolower($parms));
		$p = explode('/', $parms);
		$p = array_filter($p, 'strlen');
		if(!empty($p)) {
			$o['str'] = implode('', $p);
			$o['uri'] = implode('/', $p) . '/';
			return $o;
		}
	}
}
?>