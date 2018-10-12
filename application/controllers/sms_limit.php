<?php
/**
 * Description of sms_limit
 *
 * @author Himel
 */
class Sms_limit extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('layout');
        $loggedIn = $this->authenticate->get_user_data();
        if(empty($loggedIn))
            redirect (BASE);
        
       // $this->layout->setLayoutData($getBalance);
    }
    
    public function index()
    {
        $data = array();
        $data['script'] = 'limits';
        $data['user_type'] = $this->authenticate->get_user_type();
        $data['content'] = $this->load->view('limits/vsms_limits',$data,true);
        $this->layout->set_content($data);
    }
    
    public function save_sms_limit()
    { 
       
       $this->load->model('musers');
       $this->load->model('mcsms_limit');
       $clientId = $this->input->post('client_id');
       $clientExist = $this->musers->isExist(array('clientId'=>$clientId));
       date_default_timezone_set('Asia/Dhaka');
       if($clientExist){
           $day_limit = $this->input->post('day_limit');
           $month_limit = $this->input->post('month_limit');
           $csms_limit = $this->mcsms_limit->tbl_count_where(array('clientId'=>$clientId));
           
           if($csms_limit){
               $this->mcsms_limit->tbl_update(array('day_limit'=>$day_limit,'month_limit'=>$month_limit), array('clientId'=>$clientId));
           }else{
               $this->mcsms_limit->save(array('clientId'=>$clientId,'day_limit'=>$day_limit,'month_limit'=>$month_limit,'limit_date'=>date('Y-m-d')));
           }
       }
    }
    
}

?>
