<?php
/**
 * Description of smsapi
 * @property Api_server $api_server
 * @author Himel
 */
class Smsapi extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('api_server');    
    }
    
    public function authenticate()
    {
        $clientId = $this->input->get('clientid',true);
        $key = $this->input->get('key',true);
        $authenticate = $this->api_server->authenticate($clientId, $key);
        $response = array();
        if($authenticate)
        {
            $exist = $this->api_server->isKeyExist($clientId,$key);
            if($exist){
               $expired = $this->api_server->isTokenExpired($clientId,$key);
               if($expired)
                   $this->api_server->set_access_token($clientId, $key);
            }else{
                $this->api_server->set_access_token($clientId, $key);
            }
            
            $result = $this->api_server->get_access_token($clientId,$key);
            $response['status'] = '200';
            $response['client_id'] = $result['client_id'];
            $response['key'] = $result['key'];
            $response['access_token'] = $result['access_token'];
            $response['expire_time'] = $result['expire_time'];
            
        }else{
            $response['status'] = '500';
            $response['message'] = 'Authentication failed';
        }
        
        echo json_encode($response);
    }
    
    public function get_access_token()
    {
         $clientId = $this->input->get('clientid',true);
         $key = $this->input->get('key',true);
         //$this->api_server->isTokenExpired($clientId,$key);
         $exist = $this->api_server->isKeyExist($clientId,$key);
         $response = array();
         
         if($exist)
         {
             $response['status'] = '200';
             $response['client_id'] = $clientId;
             $response['access_token'] = $this->api_server->get_access_token($clientId,$key);
         }else{
             $response['status'] = '501';
             $response['message'] = 'Session Expired';
         }
         echo json_encode($response);
    }
    
    public function get_refresh_token($clientId,$accessToken)
    {
        $clientId = $this->input->get('clientid',true);
        $accessToken = $this->input->get('accesstoken',true);
        $exist = $this->api_server->isAccessTokenExist($clientId, $accessToken);
        $response = array();
        if($exist){
            $this->api_server->set_refresh_token($clientId, $accessToken);

            $result = $this->api_server->get_refresh_token($clientId, $accessToken);
            
            $response['status'] = '200';
            $response['client_id'] = $clientId;
            $response['access_token'] = $result['access_token'];
            $response['refresh_token'] = $result['refresh_token'];
            if(empty($result)){
               $response['message'] = 'Access Token Not Valid'; 
            }
        }else{
            $response['status'] = '502';
            $response['message'] = 'Access Token Not Valid';
        }
        
        echo json_encode($response);
    }
    
    public function get_sms_balance()
    {
        $clientid = $this->input->post('clientid',true);
        $accessToken = $this->input->post('accesstoken',true);
        if(!empty($clientid) && !empty($accessToken))
        {
            $access_token_exist = $this->api_server->isAccessTokenExist($clientid, $accessToken);
            if($access_token_exist)
            {
              $result = $this->api_server->get_sms_balance($clientid); 
              $response['status'] = '200';
              $response['client_id'] = $clientid;
              $response['access_token'] = $accessToken;
              //$response['result'] = (!empty($result))? $result : array();
              $response['count'] = (!empty($result))? count($result) : 0;
              $response['message'] = 'OK';
            }else{
                $response['status'] = '502';
                $response['message'] = 'Token Not Valid';
            }
            
        }else{
            $response['status'] = '505';
            $response['message'] = 'Invalid Request';
        }
        echo json_encode($response);
    }
    
    public function get_client_daily_sms_count()
    {
    	$clientId = $this->input->post('clientid',true);
    	$accessToken = $this->input->post('accesstoken',true);
    	$date = $this->input->post('date',true);
    	$response = array();
    	if(!empty($clientId) && !empty($accessToken))
    	{
    		$access_token_exist = $this->api_server->isAccessTokenExist($clientId,$accessToken);
    		if($access_token_exist)
    		{
    			$result = $this->api_server->get_daily_sms_count($clientId,$date);
    			$response['status'] = '200';
    			$response['client_id'] = $clientId;
    			$response['access_token'] = $accessToken;
    			$response['count'] = $result['result'];
    			$response['message'] = 'OK';
    			$response['sql']=$this->db->last_query();
    		}
    		else
    		{
    			$response['status'] = '502';
    			$response['message'] = 'Token Not Valid';
    		}
    	}else{
    	        $response['clientid'] = $clientId;
    	        $response['accessToken'] = $accessToken;
    		$response['status'] = '505';
    		$response['message'] = 'Invalid Request';
    	}
    	echo json_encode($response);
    }
    
    public function save_message_to_queue()
    {
        $clientid = $this->input->post('clientid',true);
        $accessToken = $this->input->post('accesstoken',true);
        $refreshToken = $this->input->post('refreshtoken',true);
        $message = $this->input->post('message',true);
        $response = array();
        if(!empty($clientid) && !empty($accessToken) && !empty($refreshToken) && !empty($message)){
            
            $access_token_exist = $this->api_server->isAccessTokenExist($clientid, $accessToken);
            $refresh_token_exist = $this->api_server->isRefreshTokenExist($clientid, $refreshToken);
            if($access_token_exist && $refresh_token_exist)
            {
                $message = str_replace("&lt;","<",$message);
                $message = str_replace("&gt;",">",$message);
                $xmlObj = $this->xmlParser($message);
                $this->api_server->save_message_data($xmlObj);
                $this->api_server->set_refresh_token($clientid, $accessToken);

                $result = $this->api_server->get_refresh_token($clientid, $accessToken);
                $response['status'] = '200';
                $response['client_id'] = $clientid;
                $response['refresh_token'] = $result;
                $response['message'] = 'Message Queued Successfully';
            }else{
                $response['status'] = '502';
                $response['message'] = 'Token Not Valid';
            }
        }else{
            $response['status'] = '505';
            $response['message'] = 'Invalid Request';
        }
        echo json_encode($response);
    }

    public function remove_access_token()
    {
        $clientid = $this->input->post('clientid',true);
        $accessToken = $this->input->post('accesstoken',true);
        $key = $this->input->post('key',true);
        $response = array();
        if(!empty($clientid) && !empty($accessToken)){
            $access_token_exist = $this->api_server->isAccessTokenExist($clientid, $accessToken);
            if($access_token_exist)
            {
                $this->api_server->deleteToken($clientid,$key);
                $response['status'] = '200';
                $response['message'] = 'Access Token Successfully removed';
            }else{
                $response['status'] = '502';
                $response['message'] = 'Token Not Valid';
            }
        }else{
            $response['status'] = '505';
            $response['message'] = 'Invalid Request';
        }
    }
    
    private function xmlParser($xmlStr)
    {
        $xmlObj = simplexml_load_string($xmlStr);
        return $xmlObj;
    }
    
    
}
?>
