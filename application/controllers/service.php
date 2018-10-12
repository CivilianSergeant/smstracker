<?php
/**
 * Description of service
 * @property Mservices $mservices
 * @property Authenticate $authenticate
 * @author Himel
 */
class Service extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('layout');
        $this->load->model('msms_balance');
        $loggedIn = $this->authenticate->get_user_data();
        if(empty($loggedIn))
            redirect (BASE);
        
        $LBalance = $getBalance = $this->msms_balance->tbl_get(array('balance_status' => 1));
        $this->layout->setLayoutData($LBalance);
    }
    
    public function index()
    {
        
    }
    
    public function get_report()
    {
       if($this->request->is_XmlHttpRequest())
       {
           $view_type = $this->input->post('view_type');
           $report_option = $this->input->post('report_option');
           $domain = $this->input->post('domain');
           $this->load->model('mservices');
           $date_from = $this->input->post('dateFrom');
           $date_to = $this->input->post('dateTo'); 
           $response = array();
           switch($view_type)
           {
               /*case 'ALL':
                   
                   switch($report_option)
                   {
                      case 'none':
                          $response['result'] = $this->mservices->get_report_summary();
                          break;
                      case 'today':
                          $response['result'] = $this->mservices->get_report_summary('','today');
                          break;
                      
                      case 'custom':
                          
                          $timestampFrom = strtotime($date_from);
                          $timestampTo = strtotime($date_to);
                          $this->mservices->init('',$date_from,$date_to);
                          if($timestampFrom < $timestampTo)
                          {
                              
                              $response['result'] = $this->mservices->get_report_summary();
                          }
                          
                          break;
                      
                      default:
                          
                          $response['result'] = $this->mservices->get_report_summary($report_option);
                          break;
                   
                   }
                   
                   break;
               
               
               case 'SW':
                     
                   switch($report_option)
                   {
                      case 'none':
                          
                          $this->mservices->init($domain,'','');
                          
                          $response['result'] = $this->mservices->get_report_summary();
                          break;
                      case 'today':
                          $this->mservices->init($domain,'','');
                          $response['result'] = $this->mservices->get_report_summary('','today');
                          break;
                      
                      case 'custom':
                          
                          $timestampFrom = strtotime($date_from);
                          $timestampTo = strtotime($date_to);
                          $this->mservices->init($domain,$date_from,$date_to);
                          if($timestampFrom < $timestampTo)
                          {
                              $response['result'] = $this->mservices->get_report_summary();
                          }
                          
                          break;
                      
                      default:
                          
                          $this->mservices->init($domain,'','');
                          $response['result'] = $this->mservices->get_report_summary($report_option);
                          break;
                   
                   }
                   break;*/
                   
              case 'Custom':
                  $this->load->model('smsreport');
                  $clientId = $this->input->post('client_id');
                  $smsReport = new SmsReport();
                  if(!empty($clientId)){
                      switch($report_option)
                      {
                          case 'none':

                              $response['user_type'] = $this->authenticate->get_user_type();
                              $response['result'] = '';
                              break;

                          case 'today':

                              $response['user_type'] = $this->authenticate->get_user_type();
                              $response['result'] = $smsReport->getReportToday($clientId,'',true,1);
                              break;

                          case 'custom':
    //                          echo $clientId;
                              $response['user_type'] = $this->authenticate->get_user_type();
                              $response['result'] = $smsReport->getReportBetweenDate($clientId, $date_from, $date_to,true,1);
                              break;

                          default:

                              $response['user_type'] = $this->authenticate->get_user_type();
                              $response['result'] = $smsReport->getReportByDuration($clientId, $report_option,true,1);
                              break;
                      }
                  }else{
                    $response['result'] = '<h4 style="color:tomato;">Client Not Selected.</h4>';  
                  }
                  break;
              case 'Client':
                 
                  $this->load->model('smsreport');
                  $clientId = $this->input->post('client_id');
                  $smsReport = new SmsReport(); 
                  switch($report_option)
                   {
                      case 'none':
                          
                          $response['user_type'] = $this->authenticate->get_user_type();
                          $response['result'] = '';
                          break;
                      
                      case 'today':
                         
                          $response['user_type'] = $this->authenticate->get_user_type();
                          $response['result'] = $smsReport->getReportToday($clientId,'',true,1);
                          break;
                      case 'custom':
//                          echo $clientId;
                          $response['user_type'] = $this->authenticate->get_user_type();
                          $response['result'] = $smsReport->getReportBetweenDate($clientId, $date_from, $date_to,true,1);
                          break;
                      default:
                          
                          $response['user_type'] = $this->authenticate->get_user_type();
                          $response['result'] = $smsReport->getReportByDuration($clientId, $report_option,true,1);
                          break;
                   }
                  
                  break;
           }
           
           //echo $this->db->last_query();
           $this->load->view('report/vsms_report_summary',$response);
       }
       else
       {
           redirect(BASE);
       }
    }
    
    public function get_client_details()
    {
        error_reporting(E_ALL);
        if($this->request->is_XmlHttpRequest())
       {
            $this->load->model('musers');
            $this->load->model('smsreport');
            $clientId = $this->input->post('client_id');
            $date = $this->input->post('date');
            $masking = $this->input->post('masking');
            $data = array();
            $result = $this->smsreport->getSMSDetailsReport($clientId,$date,$masking);
            
            $data['clientInfo'] = $this->musers->get_user($clientId);
            $data['date'] = $date;
            $data['result'] = (!empty($result))? $result : array();
            
            $this->load->view('report/sms_details',$data);
       }else{
           redirect(BASE);
       }
        
    }
       
    public function get_details()
    {
       if($this->request->is_XmlHttpRequest())
       {
           
           $report_option = $this->input->post('report_option');
           $domain = $this->input->post('domain');
           $this->load->model('mservices');
           $date_from = $this->input->post('dateFrom');
           $date_to = $this->input->post('dateTo');
           $data = array();
           
           $result = array();        
           switch($report_option)
           {
              case 'none':
                          
              $this->mservices->init($domain,'','');
              $data['reportOf'] = 'All';
              $result = $this->mservices->get_report_details();
              break;
          case 'today':
              $this->mservices->init($domain,'','');
              $data['reportOf'] = 'today';
              $result = $this->mservices->get_report_details('','today');
              break;

          case 'custom':

              $timestampFrom = strtotime($date_from);
              $timestampTo = strtotime($date_to);
              $this->mservices->init($domain,$date_from,$date_to);
              if($timestampFrom < $timestampTo)
              {
                  $data['reportOf'] = $date_from.'-'.$date_to;
                  $result = $this->mservices->get_report_details();
              }
              
              break;

          default:
              $this->mservices->init($domain,'','');
              $data['reportOf'] = $report_option.' days';
              $result = $this->mservices->get_report_details($report_option);
              break;

           }
                   
           
           $data['result'] = (!empty($result))? array_shift($result) : array();
           $method=$this->uri->segment(2);
           $data['script'] = (!empty($method))? $method : 'no';
           $data['user_type'] = $this->authenticate->get_user_type();
           $data['content'] = $this->load->view('report/vsms_report_details',$data,true);
           $this->layout->set_content($data);
       }
       else
       {
           redirect(BASE);
       }
    }
    
}

?>
