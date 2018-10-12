<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mlogin
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter'.EXT;

class MAuth extends MY_adapter{

    private $table = "users";
    
    public function __construct() {
        parent::__construct($this->table);
    }
    
    public function login($username,$password)
    {
        
        $result = $this->tbl_get(array(
            'user_name' => $username,
            'user_pass' => md5($password),
            'user_status' => 1
        ),1);
        return $result;
    }
    
    public function api_login($clientId,$key)
    {
        $initial = strlen($clientId)? $clientId[0] : '';
        if(strtolower($initial) == 'c'){
            $result = $this->tbl_get(array(
                'clientId' => $clientId,
                'key' => $key,
                'user_status' => 1
            ));
        }else{
            $this->db->where('clientid',$clientId);
            $this->db->where('key',$key);
            $this->db->limit(1);
            $recordset = $this->db->get('domain');
            $result = $recordset->result_array();
        }
        
        return $result;
    }
    
}

?>
