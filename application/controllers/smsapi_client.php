<?php

/**
 * Description of smsapi_client
 *
 * @author Himel
 */
class smsapi_client extends CI_Controller{

    private $client_id;
    private $key;
    
    public function __construct()
    {
        parent::__construct();
        $loggedIn = $this->authenticate->get_user_data();
        if(empty($loggedIn))
            redirect (BASE);
        
        $clientid = $this->msettings->get_settings(array('key'=>'CLIENT_ID'));
        $apikey = $this->msettings->get_settings(array('key'=>'API_KEY'));
        $this->client_id = $this->authenticate->get_client_id();
        $this->key = $this->authenticate->get_api_key();
    }
    
    public function index()
    {
        echo 'hello';
    }
    
    
}

?>
