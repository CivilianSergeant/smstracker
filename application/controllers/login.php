<?php
/**
 * Description of login
 *
 * @author Himel
 */
class login extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $data = array();
        $loggedIn = $this->authenticate->get_user_data();
        if($loggedIn)
            redirect(BASE.'dashboard/');
        
        if($this->request->is_XmlHttpRequest())
        {    
            $location = array();
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $login = $this->authenticate->authenticate($username,$password);
            if($login)
            {   $location['loc'] = BASE.'dashboard/';
                $location['status'] = 1;
            }else
            {
                $location['loc'] = BASE;
                $location['status'] = 0;
            }
            echo json_encode($location);
            exit;
        }
        
        $this->load->view('vlogin',$data);
    }
    
    public function logout()
    {
        $this->authenticate->clear_userdate();
        redirect(BASE);
    }
    
}

?>
