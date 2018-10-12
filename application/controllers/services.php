<?php

/**
 * Description of services
 *
 * @author Himel
 */
class Services extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        redirect(BASE);
    }
    
    public function getSMSLimit()
    {
        $link = urldecode($this->uri->segment(3));
        $this->load->model('msms_limit');
        $result = $this->msms_limit->tbl_get(array('school_id'=>$link));
        $response = array();
        if(!empty($result))
        {
            $response['result'] = $result;
            $response['status'] = 200;
            echo json_encode($response);
        }else{
            redirect(BASE);
        }
    }
    
}

?>
