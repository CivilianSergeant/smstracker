<?php

/**
 * Description of limits
 * @property Authenticate $authenticate
 * @author Himel
 */
class Limits extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('msms_balance');
        $this->load->library('layout');
        $loggedIn = $this->authenticate->get_user_data();
        if(empty($loggedIn))
            redirect (BASE);
        
        $getBalance = $this->msms_balance->tbl_get(array('balance_status' => 1));
        $this->layout->setLayoutData($getBalance);
    }
    
    public function index()
    {
        $this->load->model('msms_limit');
        $data = array();
        $data['script'] = 'limits';
        $data['user_type'] = $this->authenticate->get_user_type();
        $getBalance = $this->msms_balance->tbl_get(array('balance_status' => 1));
        $data['balance'] = (!empty($getBalance))? array_shift($getBalance) : array();
        $data['limits'] = $this->msms_limit->getLimits();
        $data['content'] = $this->load->view('limits/vlimits',$data,true);
        $this->layout->set_content($data);
    }
    
    public function save_limit()
    {
        if($this->request->is_XmlHttpRequest())
        {
            $this->load->model('msms_limit');
            $exist = $this->msms_limit->isExist(array('school_id' => $this->input->post("schoolId")));
            if($exist)
            {
             $this->msms_limit->tbl_update(
                      array('num_of_student'=> $this->input->post("num_stud"),
                            'sms_limit' => $this->input->post("limit")
                            ),
                      array('school_id'=>$this->input->post("schoolId")));  
            }
            else
            {
              $this->msms_limit->save(array(
                 'domain_id' => $this->input->post('domainID'),
                 'school_id' => $this->input->post("schoolId"),
                 'num_of_student' => $this->input->post("num_stud"),
                 'sms_limit' => $this->input->post("limit")
              ));
            }
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function sms_limit()
    {        
        $this->load->model('mcsms_limit');
        $this->load->model('musers');
        
        $clientID = $this->uri->segment(3);
        $clientExist = $this->musers->isExist(array('clientId'=>  mysql_escape_string($clientID)));
        
        
            if($clientExist){
            $data = array();
            $data['script'] = 'limits';

            $data['client'] = $this->mcsms_limit->tbl_get(array(
                'clientId' => trim($clientID),
            ));
            
            $this->db->select('*,sms_masking.masking_id as maskingId');
            $this->db->from('sms_masking');
            $this->db->join('client_masking','sms_masking.masking_id = client_masking.masking_id','left');
            
            $maskings = $this->db->get();
            $data['maskings'] = $maskings->result_array();

            $data['clientInfo'] = $this->musers->tbl_get(array('clientId'=>trim($clientID)));
            $data['content'] = $this->load->view('limits/vsms_limit',$data,true);
            $this->layout->set_content($data);
        }else{
            redirect(BASE);
        }
    }
    
    public function save_client_masking()
    {
        $clientId = $this->input->post('client_id');
        $masking = $this->input->post('masking');
//        if(!empty($maskings))
//        {
//            foreach($maskings as $masking)
//            {
                 $this->db->where(array('client_id'=>$clientId, 'masking_id'=>$masking));
                 $exist = $this->db->count_all_results('client_masking');
                 if(empty($exist)){
                    $this->db->insert('client_masking',array('client_id'=>$clientId,'masking_id'=>$masking));
                 }
//            }
//        }
    }
    
    public function update_client_masking(){
        $clientId = $this->input->post('client_id');
        $masking = $this->input->post('masking');
        
        $this->db->where(array('client_id'=>$clientId, 'masking_id'=>$masking));
        $exist = $this->db->count_all_results('client_masking');
        if(!empty($exist)){
            $this->db->where(array('client_id'=>$clientId, 'masking_id'=>$masking));
            $this->db->delete('client_masking');
        }
        
    }
    
    
    
}

?>
