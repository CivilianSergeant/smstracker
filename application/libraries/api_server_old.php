<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_session
 *
 * @author Himel
 */
class Api_server {
    
    private $CI;
    private $table="users_token";
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->helper('function');
    }
    
    public function authenticate($clientId,$key)
    {
        error_reporting(E_ALL);
        $this->CI->load->model('mauth');
        $result = $this->CI->mauth->api_login($clientId,$key);
        if(!empty($result))
        {
            $result = array_shift($result);         
            return $result;
        }
        else
        {
            return 0;
        }
        
    }

    public function set_access_token($clientId,$key)
    {     
        $accessToken = $this->_generateToken();
        $this->CI->db->insert($this->table,array('client_id'=>$clientId,'key'=>$key,'access_token'=>$accessToken,'refresh_token'=>'','expire_time'=>(time()+(60*30))));   
    }
    
    public function get_access_token($clientId,$key)
    {
       $this->CI->db->where('client_id',$clientId); 
       $this->CI->db->where('key',$key); 
       $recordset = $this->CI->db->get($this->table);
       $result = $recordset->result_array();
       return (!empty($result))? array_shift($result): array();
    }
    
    public function set_refresh_token($clientId,$accessToken)
    {
       $this->CI->db->where('client_id',$clientId); 
       $this->CI->db->where('access_token',$accessToken); 
       $refreshToken = $this->_generateRefreshToken($accessToken);
       $this->CI->db->update($this->table,array('refresh_token'=>$refreshToken),array('client_id'=>$clientId,'access_token'=>$accessToken));
    }
    
    public function get_refresh_token($clientId,$accessToken)
    {
      
       $this->CI->db->where('client_id',$clientId); 
       $this->CI->db->where('access_token',$accessToken); 
       $recordset = $this->CI->db->get($this->table);
       $result = $recordset->result_array();
       return (!empty($result))? array_shift($result): array();
    }
    
    public function deleteToken($clientId,$key)
    {
        
       $this->CI->db->delete($this->table,array('client_id'=>$clientId,'key'=>$key));
       return $this->CI->db->affected_rows();
    }
    
    public function isTokenExpired($clientId,$key)
    {
       $this->CI->db->where('client_id',$clientId); 
       $this->CI->db->where('key',$key); 
       $this->CI->db->order_by('id','desc'); 
       $result = $this->CI->db->get($this->table);
       $row = $result->result_array();
       if(!empty($row)){
           $token = array_shift($row);
           $expire_time = $token['expire_time'];
           $now_timestamp = time();
           if($expire_time < $now_timestamp)
           {
              return $this->deleteToken($clientId, $key);
           }
       }
       return false;
    }
    
    public function isKeyExist($clientId,$key)
    {
        $this->CI->db->where('client_id',$clientId);
        $this->CI->db->where('key',$key);
        return $this->CI->db->count_all_results($this->table);
    }
    
    public function isAccessTokenExist($clientId,$accssToken)
    {
        $this->CI->db->where('client_id',$clientId);
        $this->CI->db->where('access_token',$accssToken);
        return $this->CI->db->count_all_results($this->table);
    }
    
    public function isRefreshTokenExist($clientId,$refreshToken)
    {
        $this->CI->db->where('client_id',$clientId);
        $this->CI->db->where('refresh_token',$refreshToken);
        return $this->CI->db->count_all_results($this->table);
    }
    
    public function save_message_data($xmlObj)
    {
        
        $this->CI->load->model('message');
        $this->CI->load->model('messagequeue');
        
        foreach($xmlObj as $node){
            
            $message = new Message();
            $message->mobileNumber = $node->number;
            $message->message = $node->content;
            $message->subject = $node->subject;
            $message->scheduleTime = "";
            $message->toWhom = $node->recipient;
            $messageQueue =  new MessageQueue();
            $smsSent = $messageQueue->storeMessage($node->clientid, $message);
        }
        
       
    }
    

    private function _generateToken()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz.0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $token1 = ""; $token2 = ""; $token3 = "";    

        for ($p = 0; $p < 20; $p++) {

            $token1 .= $characters[mt_rand(0, strlen($characters)-1)];

            $token2 .= $characters[mt_rand(0, strlen($characters)-1)];

            $token3 .= $characters[mt_rand(0, strlen($characters)-1)];

        }
        return substr($token1.$token2.$token3,0,40);
    }
    
    private function _generateRefreshToken($accessToken)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz.0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $token1 = ""; $token2 = ""; $token3 = "";    

        for ($p = 0; $p < 20; $p++) {

            $token1 .= $characters[mt_rand(0, strlen($characters)-1)];

            $token2 .= $characters[mt_rand(0, strlen($characters)-1)];

            $token3 .= $characters[mt_rand(0, strlen($characters)-1)];

        }
        return sha1($accessToken.$token1.$token2.$token3.time());
    }
    
    
    
    
    
    
}

?>
