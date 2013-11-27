<?php
/**
 * Class: addressValidation
 * Author: Ryan Born
 *
 * Description: validates mailing addresses using
 * smartystreets API.
 */
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

		if(isset($this->response['Error'])){
			return $this->response;
		}
		$response = $this->buildResponse();
		return $response;
	}

	/**
	 * Builds request url
	 *
	 * @param array $data
	 * @return void
	 */
	private function buildURL($data){
		foreach($data as &$element){
			$element = str_replace(" ","+",$element);
		}

		$this->requestURL = self::$endpoint.'?street='.$data['Address1'].'&city='.$data['City'].'&state='.$data['State'].'zipcode='.$data['Zip5'].'&candidates=1&auth-id='.self::$authId.'&auth-token='.self::$authToken;
	}

	/**
	 * sends the request to request url
	 *
	 * @return void
	 */
	private function sendRequest(){
		// use curl to better handle errors
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->requestURL);

		$this->response = curl_exec($ch);
		if(curl_errno($ch) === 0){
			$this->response = false;
		}
	}

	/**
	 * parses response from API and builds return array
	 *
	 * @return array $response
	 */
	private function buildResponse(){
		if($this->response == false){
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