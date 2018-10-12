<?php
/**
 * Created by PhpStorm.
 * User: HimelC51
 * Date: 12/7/14
 * Time: 12:19 PM
 */

class Line extends CI_Controller {

    const SMS_CHAR_LIMIT = 160;

    public function __construct() {
        parent::__construct();
        $this->load->library('layout');

        $loggedIn = $this->authenticate->get_user_data();
        if(empty($loggedIn))
            redirect (BASE);
    }

    public function index()
    {
        $this->load->model('sms_masking');
        $this->load->model('SmsProvider');
        $this->load->model('lines');
        $data = array();
        $data['masking'] = $this->sms_masking->tbl_get();
        $data['provdiers'] = $this->SmsProvider->tbl_get();
        $lines = $this->lines->tbl_get();
        $segment = $this->uri->segment(3);
        $lineNumbers = array();
        foreach($lines as $line)
        {
            if($line['active'])
                $lineNumbers[$line['masking']][$line['provider']] = $line['line_number'];
        }
        $data['lines'] = $lineNumbers;
        $data['msg'] = (!empty($segment) && $segment == 1)? 'Line Settings Updated' : '';
        $data['content'] = $this->load->view('line/vline',$data,true);
        $this->layout->set_content($data);
    }

    public function updateline()
    {
        error_reporting(E_ALL);
        $this->load->model('lines');

        if($this->request->is_Post())
        {
           $lines =  $this->input->post('line');

           if(count($lines))
           {

               foreach($lines as $key => $line)
               {
                   foreach($line as $provider=> $l)
                   {
                       $lineNumber = trim($l);
                       $key = trim($key);
                       if(!empty($lineNumber))
                       {
                           $exists = $this->lines->tbl_count_where(array('masking'=>$key,'provider'=>$provider,'line_number'=>$lineNumber));

                           if($exists==0)
                           {
                               $this->lines->tbl_update(array('active'=>0),array('masking'=>$key,'provider'=>$provider));
                               $this->lines->save(array('active'=>1,'masking'=>$key,'line_number'=>$lineNumber,'provider'=>$provider));
                           }else{


                               $this->lines->tbl_update(array('active'=>0),array('masking'=>$key,'provider'=>$provider));
                               $this->lines->tbl_update(array('active'=>1),array('line_number'=>$lineNumber,'masking'=>$key,'provider'=>$provider));

                           }
                       }
                   }
               }
           }
        }
        redirect('line/index/1');

    }
}