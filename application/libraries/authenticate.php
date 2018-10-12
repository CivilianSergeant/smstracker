<?php
/**
 * Description of authenticate
 *
 * @author Himel
 */
class Authenticate {
    
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    public function authenticate($username,$pass)
    {
        $this->CI->load->model('mauth');
        $result = $this->CI->mauth->login($username,$pass);
        if(!empty($result))
        {
            $this->set_user_data(array_shift($result));
            return 1;
        }
        else
        {
            return 0;
        }
        
    }
    
    private function set_user_data($data)
    {
        $this->CI->session->set_userdata(BASE,$data);
    }
    
    public function get_user_data()
    {
        return $this->CI->session->userdata(BASE);
    }
    
    public function clear_userdate()
    {
        return $this->CI->session->unset_userdata(BASE);
    }
    
    public function get_user_type()
    {
        $userdata = $this->CI->session->userdata(BASE);
        return $userdata['user_type'];
    }
    
    public function get_user_name()
    {
        $userdata = $this->CI->session->userdata(BASE);
        return $userdata['user_name'];
    }
    
    public function get_user_id()
    {
        $userdata = $this->CI->session->userdata(BASE);
        return $userdata['user_id'];
    }
    
    public function get_client_id()
    {
        $userdata = $this->CI->session->userdata(BASE);
        return $userdata['clientId'];
    }
    
    public function get_api_key()
    {
        $userdata = $this->CI->session->userdata(BASE);
        return $userdata['key'];
    }
    
    
    
    
}

?>
