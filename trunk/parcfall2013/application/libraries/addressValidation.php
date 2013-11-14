<?php
class addressValidation{
	private static $endpoint = "https://api.smartystreets.com/street-address";
	private static $authId = "55d1caf0-8687-4c74-881a-40562cbd8b5a";
	private static $authToken = "Hm%2BHaonkZof%2FS1BY2MgjC01ENekIcV5Lk3TIj3pBBsQWsUO1RnXRefOxRS3Y9HEiK8iQXnzxobQXDJS4kiyCCQ%3D%3D";
	private $requestURL;
	private $response;

	/**
	 * Validate an address
	 *
	 * @param array $data
	 * @return array $returnData
	 */
	public function validate($data){
		$this->buildURL($data);
		$this->sendRequest();

		$response = $this->buildResponse();
		return $response;
	}

	private function buildURL($data){
		foreach($data as &$element){
			$element = str_replace(" ","+",$element);
		}

		$this->requestURL = self::$endpoint.'?street='.$data['Address1'].'&city='.$data['City'].'&state='.$data['State'].'zipcode='.$data['Zip5'].'&candidates=1&auth-id='.self::$authId.'&auth-token='.self::$authToken;
	}

	private function sendRequest(){
		$this->response = file_get_contents($this->requestURL);
	}

	private function buildResponse(){
		if($this->response == "[]"){
			return array("Error"=>true);
		}else{
			$this->response = json_decode($this->response);
			$response = array();
			$response['Address1'] = $this->response[0]->delivery_line_1;
			if(isset($this->response[0]->delivery_line_2)){
				$response['Address2'] = $this->response[0]->delivery_line_2;
			}else{
				$response['Address2'] = '';
			}
			$response['City'] = $this->response[0]->components->city_name;
			$response['State'] = $this->response[0]->components->state_abbreviation;
			$response['Zip5'] = $this->response[0]->components->zipcode;
			$response['Zip4'] = $this->response[0]->components->plus4_code;
			return $response;
		}
	}
}


?>