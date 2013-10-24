<?php
class uspsAddressValidation{
     private static $endpoint = "http://production.shippingapis.com/ShippingAPITest.dll";
     private static $userId = "305PARC04203";
     private static $password = "177CM21GN702";
     private $requestURL;
     private $response;

     public function validate($data){
          $this->buildURL($data);
          $this->sendRequest();
          $response = new SimpleXMLElement($this->response);
          if(isset($response->Address->Error)){
               return json_encode(array("Error"=>true,"ErrorMsg"=>(string)$response->Address->Error->Description));
          }
          return json_encode(array(
          	"Error"=>false,
               "Address1"=>(string)$response->Address->Address1,
               "Address2"=>(string)$response->Address->Address2,
               "City"=>(string)$response->Address->City,
               "State"=>(string)$response->Address->State,
               "Zip5"=>(string)$response->Address->Zip5,
               "Zip4"=>(string)$response->Address->Zip4
          ));
     }

     private function buildURL($data){
          $this->requestURL = self::$endpoint.'?API=Verify&XML=
          <AddressValidateRequest%20USERID="'.self::$userId.'">
               <Address>
                    <Address1>'.str_replace(" ", "%20", $data['Address1']).'</Address1>
                    <Address2>'.str_replace(" ", "%20", $data['Address2']).'</Address2>
                    <City>'.str_replace(" ", "%20", $data['City']).'</City>
                    <State>'.str_replace(" ", "%20", $data['State']).'</State>
                    <Zip5>'.str_replace(" ", "%20", $data['Zip5']).'</Zip5>
                    <Zip4>'.str_replace(" ", "%20", $data['Zip4']).'</Zip4>
               </Address>
          </AddressValidateRequest>';
          $this->requestURL = str_replace("\n","",$this->requestURL);
          $this->requestURL = str_replace("\r","",$this->requestURL);
          $this->requestURL = str_replace(" ","",$this->requestURL);
     }

     private function sendRequest(){
          $this->response = file_get_contents($this->requestURL);
     }
}

?>