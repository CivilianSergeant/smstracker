<?php
/**
 * Description of dashboard
 *
 * @author Himel
 * @property Authenticate $authenticate
 * @property Mdb $mdb
 * @property Muser $muser
 * @property Layout $layout
 */
class Dashboard extends CI_Controller{
    
    const SMS_CHAR_LIMIT = 160;
    
    public function __construct() {
        parent::__construct(); 
        
        $this->load->model('musers');
        $this->load->model('mdomains');
        $this->load->model('msettings');
        $this->load->model('msms_balance');
        $this->load->library('layout');
        
        $loggedIn = $this->authenticate->get_user_data();
        if(empty($loggedIn))
            redirect (BASE);
        
        $LBalance = $getBalance = $this->msms_balance->tbl_get(array('balance_status' => 1));
        $balance = (!empty($getBalance))? array_shift($getBalance): array();
        if((!empty($balance)) && $balance['balance_available'] <= REFUND_BALANCE_LIMIT)
        {
            $settings = $this->msettings->get_settings(array('key'=>'email'));
            if(!empty($settings))
            {
//                $to = $settings['value'];
//                $subject = 'SMS Balance Refund';
//                $headers = 'From: no-reply@bengalsols.com';
//                mail($to,$subject, 'Your SMS Balance reached to its limit. Please Refund SMS Balance.',$headers);
                
                
            }
        }
        $this->layout->setLayoutData($LBalance);
    }
    
    public function index()
    {
        error_reporting(E_ALL);
        $this->load->model('mcsms_limit');
        $this->load->model('messagequeue');
        $this->load->model('msettings');
        $data = array();
        $method=$this->uri->segment(2);
        
        $data['script'] = (!empty($method))? $method : 'no';
        $user_type = $this->authenticate->get_user_type();
        $data['user_type'] = $user_type;
        $data['user_id'] = $this->authenticate->get_user_id();
        $data['domains'] = $this->mdomains->tbl_get();
        if(strtolower($user_type) == 'client')
        {
            $clientID = $this->authenticate->get_client_id();
            $data['csms_limit'] = $this->mcsms_limit->tbl_get(array('clientId' => trim($clientID)));
            $this->db->like('dispatch_dt',date('Y-m'),'after');
            $this->db->where('clientId',$clientID);
            $recordSet = $this->db->get('track_sms');
            $smsUsed = $recordSet->result_array();
            $countSms = 0;
            if(!empty($smsUsed)){
                foreach($smsUsed as $smsU)
                {
                    $smsLen = (strlen(urldecode($smsU['message']))/self::SMS_CHAR_LIMIT);
                    $countSms += Ceil($smsLen); 
                }
            }
            $data['sms_used'] = $countSms;
            $data['clientList'] = $this->mdomains->getClientList();
        }else{
            $checkDayLimit = $this->messagequeue->checkDayLimit();
            $dayLimit = $this->messagequeue->getDayLimit();
            $approveSms = ($checkDayLimit >= $dayLimit) ? BASE.'dashboard/approve/'.$this->authenticate->get_user_id() : '';
            $SMS_DAY_LIMIT = $this->msettings->get_settings(array('key'=>'SMS_DAY_LIMIT'));
            $data['approveSms'] = $approveSms;
            $data['csms_limit'] = array();
            $data['clientList'] = $this->mdomains->getClientList(); //$this->musers->getClientList();
            $data['checkDayLimit'] = $checkDayLimit;
            $data['SMS_DAY_LIMIT'] = (!empty($SMS_DAY_LIMIT['value'])) ? $SMS_DAY_LIMIT['value'] : '0';
            $data['sms_used'] = array();
        }
        $data['content'] = $this->load->view('vdashboard',$data,true);
        
        $this->layout->set_content($data);
    }
    
    public function approve()
    {
        $user_id = $this->uri->segment(3);
        $this->load->model('musers');
        $this->load->model('msettings');
        $exist = $this->musers->isExist(array('user_id' => $user_id));
        if($exist)
        {
            $this->msettings->update(array('value'=>0),array('key'=>'SMS_DAY_LIMIT'));
        }
        redirect(BASE);
    }
    
    public function profile()
    {
        $data = array();
  
        $user_id = $this->authenticate->get_user_id();
        $method=$this->uri->segment(2);
        $users = $this->musers->tbl_get(array('user_id'=>$user_id),1);
        $data['user'] = (!empty($users))? array_shift($users) : array();
        $data['script'] = (!empty($method))? $method : 'no';
        $data['content'] = $this->load->view('vprofile',$data,true);
        $this->layout->set_content($data);
    }
    
 
    /******User******/
    public function users()
    {
        
        $this->load->library('pagination');
        $offset = $this->uri->segment(3);

        if (empty($offset)) {
            $offset = 0;
        }
        $limit = 15;
        $total = $this->musers->count_users();
        $config['base_url'] = BASE.'dashboard/users';
        $config['per_page'] = $limit;
        $config['total_rows'] = $total;

        $config['uri_segment'] = 3;
        $config['anchor_class'] = 'class="page"';
        $this->pagination->initialize($config);
        $data = array();
        $method=$this->uri->segment(2);
        $data['script'] = (!empty($method))? $method : 'no';
        $data['users']  = $this->musers->get_users(array(),$limit,$offset);
        $data['page_links'] = $this->pagination->create_links();
        $data['content'] = $this->load->view('users/vusers',$data,true);
        $this->layout->set_content($data);
    }
    
    public function search_user()
    {
        $data = array();
        if($this->request->is_XmlHttpRequest())
        {
            $searchTxt = $this->input->post('searchTxt');
            $stmt = "SELECT * FROM users WHERE user_name LIKE '%".$searchTxt."%'";
            $stmt .= " OR user_email = '".$searchTxt."'";
            $users = $this->musers->query($stmt);
            $data['user'] = (!empty($users))? $users : array();
            
            echo json_encode($data);
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function get_new_user_form()
    {
        $data = array();
        $data['user_type'] = $this->authenticate->get_user_type();
        $this->load->view('users/vnew_user',$data);
    }
    
    public function get_update_user_form()
    {
        if($this->request->is_XmlHttpRequest())
        { 
            $user_id = $this->input->post('user_id');
            if(!empty($user_id))
            $user = $this->musers->tbl_get(array('user_id'=>$user_id));
            
            $data['user'] = (!empty($user))? array_shift($user): array();
            $this->load->view('users/vedit_user',$data);
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function save_user()
    {
        $clientId = $this->checkClientIdAvaliable('users', 'C');
        if($this->request->is_XmlHttpRequest())
        {
            
            $pass = $this->input->post('password');
            $name = $this->input->post('user_name');
            $confirmpass = $this->input->post('confirmpassword');
            if($pass == $confirmpass)
            {
               $saved = $this->musers->save(array(
                   
                   'user_name'   => $name,
                   'user_email'   => $this->input->post('user_email'),
                   'user_pass'   => md5($pass),
                   
                   'user_type'   => $this->input->post('user_type'),
                   'clientId'    => $clientId,
                   'key'         => $clientId.sha1('Carbon51'.$name.$pass.time()),
                   'user_status' => 1,
                   
               ));
               
            }
            
        }
        else
        {
            redirect(BASE);
        }
    }
    
    private function checkClientIdAvaliable($resource,$prefix='')
    {
        $this->load->helper('function');
        
        $clientId = $prefix.generateClientId();
        $this->db->where('clientId',$clientId);
        $result = $this->db->count_all_results($resource);
        
        if($result)
        {
            $this->checkClientIdAvaliable($resource,$prefix);
        }else{
          return $clientId;  
        }
    }
    
    public function update_user()
    {
        if($this->request->is_XmlHttpRequest())
        {
            $userUpdate = array();
            $userUpdate['user_name'] = $this->input->post('user_name');
            $userUpdate['user_email'] = $this->input->post('user_email');
            $password = $this->input->post('user_pass');
            if(!empty($password))
                $userUpdate['user_pass'] = md5($password);
            $updated = $this->musers->tbl_update($userUpdate,array(
                'user_id'=>$this->input->post('user_id')
            ));
            echo $updated;

        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function delete_user()
    {
        if($this->request->is_XmlHttpRequest())
        {
            $this->musers->tbl_delete(array(
                'user_id' => $this->input->post('user_id')
            ));
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function update_credentials()
    {
        if($this->request->is_XmlHttpRequest())
        {
            $oldPass = $this->input->post('old_password');
            $userPass = $this->musers->tbl_count_where(array('user_pass' => md5($oldPass)));
            if(!empty($userPass))
            {
                $pass = $this->input->post('password');
                $confirmpass = $this->input->post('confirmpassword');
                $user_id = $this->input->post('user_id');
                if($pass == $confirmpass)
                {
                   $updated = $this->musers->tbl_update(array('user_pass'=>md5($pass)),array('user_id'=>$user_id));
                   echo 1;
                }
                else
                {
                    echo 2;
                }
            }
            else
            {
                echo 0;
            }
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function unique_user_name()
    {
        if($this->request->is_XmlHttpRequest())
        {
           $result = $this->musers->tbl_count_where(array('user_name'=>$this->input->post('user_name')));
           if($result)
               echo 1;
           else
               echo 0;
        }
        else
        {
            redirect(BASE);
        }
    }
    
    /******User******/
    
    /******settings******/
    public function settings()
    {
        $data = array();
        $method = $this->uri->segment(2);
        $data['script'] = (!empty($method))? $method : 'no';
        $data['domains'] = $this->mdomains->tbl_get();
        $data['settings']['email'] = $this->msettings->get_settings(array('key'=>'email'));
        $data['settings']['active_vendor'] = $this->msettings->get_settings(array('key'=>'active_vendor'));
        $data['content'] = $this->load->view('settings/vsettings',$data,true);
        $this->layout->set_content($data);
    }
    
    public function save_domain()
    {
        $clientId = $this->checkClientIdAvaliable('domain', 'A');
        $createUserAcc = $this->input->post('create_user');
        if($this->request->is_XmlHttpRequest())
        {
            $password = md5($this->input->post('name'));
            $name     = $this->input->post('name');
            $link     = $this->input->post('link');
            $key = $clientId.sha1('Carbon51'.$name.$password.time());
            $created = $this->mdomains->save(array(
                'name' => $name,
                'link' => $link,
                'username' => strtolower($name),
                'password' => $password,
                'clientId' => $clientId,
                'key' => $key
            ));

            if($created && $createUserAcc)
            {
                $saved = $this->musers->save(array(
                   
                   'user_name'   => $name,
                   'user_email'   => '',
                   'user_pass'   => md5($name),
                   
                   'user_type'   => 'client',
                   'clientId'    => $clientId,
                   'key'         => $key,
                   'user_status' => 1,
                   
               ));
            }
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function get_domain_edit_form()
    {
        if($this->request->is_XmlHttpRequest())
        {
            $data = array();
            $domain_id = $this->input->post('domain_id');
            $domain = $this->mdomains->tbl_get(array('domain_id' => $domain_id));
            $data['domain'] = (!empty($domain))? array_shift($domain) : array();
            $this->load->view('settings/vedit_domain',$data);
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function update_domain()
    {
        if($this->request->is_XmlHttpRequest())
        {
            $update = $this->mdomains->tbl_update(array(
                'name' => $this->input->post('name'),
                'link' => $this->input->post('link')
            ),array('domain_id' => $this->input->post('domain_id')));
        }
        else
        {
            redirect(BASE);
        }
        
    }
    
    public function update_settings()
    {
        $this->load->model('msettings');
        if($this->request->is_XmlHttpRequest())
        { 
            $email = $this->input->post('email');
            $active_vendor = $this->input->post('active_vendor');

            $this->msettings->update(array('value'=>$email),array('key'=>'email'));
            $this->msettings->update(array('value'=>$active_vendor),array('key'=>'active_vendor'));

        }
        else
        {
            redirect(BASE);
        }
    }
    /******settings******/
    
    
    /*******sms*********/
    public function sms()
    {
        $this->load->model('mcsms_limit');
        $data = array();
        $method = $this->uri->segment(2);
        $data['script'] = (!empty($method))? $method : 'no';
        //$data['error'] = $this->input->get('error',true);
        $user_type = $this->authenticate->get_user_type();
        $data['user_type'] = $user_type;
        $data['error'] = $_GET['error'];
        if(strtolower($user_type) == 'client'){
            redirect(BASE);
            $this->db->from('client_masking');
            $this->db->join('sms_masking','sms_masking.masking_id = client_masking.masking_id','left');
            $this->db->where('client_masking.client_id',$this->authenticate->get_client_id());
            $result = $this->db->get();
            $model = $result->result_array(); 
            $data['masking'] = (!empty($model))? $model : array();
            
            
            $clientID = $this->authenticate->get_client_id();
            $csms_limit = $this->mcsms_limit->tbl_get(array('clientId' => trim($clientID)));
            
            $this->db->like('dispatch_dt',date('Y-m'),'after');
            $this->db->where('clientId',$clientID);
            $recordSet = $this->db->get('track_sms');
            $smsUsed = $recordSet->result_array();
            $countSms = 0;
            if(!empty($smsUsed)){
                foreach($smsUsed as $smsU)
                {
                    $smsLen = (strlen(urldecode($smsU['message']))/self::SMS_CHAR_LIMIT);
                    $countSms += Ceil($smsLen); 
                }
            }
            $smsAvailable = (!empty($csms_limit))? array_shift($csms_limit) : array();
//            echo $countSms;
//            echo $smsAvailable['month_limit'];
            $data['limit'] = (!empty($smsAvailable['month_limit']))? $smsAvailable['month_limit'] : 0;
            $data['used'] = (!empty($countSms))? $countSms :0;
        }else{
            $result = $this->db->get('sms_masking');
            $model = $result->result_array(); 
            $data['masking'] = (!empty($model))? $model : array();
        }
        $data['content'] = $this->load->view('sms/index',$data,true);
        $this->layout->set_content($data);
    }
    
    public function sms_sent()
    {
        error_reporting(E_ALL);
        $this->load->model('Message');
        $this->load->model('MessageQueue');
        $this->load->model('msettings');
        if($this->request->is_XmlHttpRequest())
        {
            $schedule_status = $this->input->post('schedule_status');
            $ss_date = $this->input->post('ss_date');
            $hour = $this->input->post('hour');
            $min = $this->input->post('min');
            $sec = $this->input->post('sec');
            $subject = trim($this->input->post('subject'));
            $txt_message = trim($this->input->post('message'));
            $number = trim($this->input->post('number'));
            $clientId = $this->authenticate->get_client_id();
            
            if((!empty($subject)) && (strlen($number) == 11) && (!empty($txt_message)))
            {
                $number = preg_replace('/^88/', "", $number);
                $message = new Message();
                $message->mobileNumber = $number;
                $message->subject = $subject;
                $message->toWhom = '';
                $message->message = $txt_message;
                if($schedule_status)
                {  
                    $schedule_time = date("Y-m-d",strtotime($ss_date)). ' '. $hour.':'.$min.':'.$sec;
                    $message->scheduleTime = $schedule_time;
                }else{
                    $message->scheduleTime = "";
                }
                
                $messageQueue =  new MessageQueue();
                $smsSent = $messageQueue->storeMessage($clientId, $message);
                $checkDayLimit = $messageQueue->checkDayLimit();
                $dayLimit = $messageQueue->getDayLimit();
               
                if($checkDayLimit >= $dayLimit)
                {
                    $header = 'Content-type:text/html;charset=iso-8859-1';
                    $message = 'Please check your profile. '.$checkDayLimit.' sms waiting for ur approval.';
                    $this->msettings->update(array('value'=>1),array('key'=>'SMS_DAY_LIMIT'));
                    try{
                        mail(MessageQueue::TO,  MessageQueue::SUBJECT, $message,$header);
                    }catch(Exception $ex)
                    {
                        //
                    }
                } 
                
                echo $smsSent;
            }else{              
                echo 0;
            }
        }
        else
        {
            redirect(BASE);
        }
    }
    
    public function bulk_sms_sent()
    {
        error_reporting(E_ALL);
        $this->load->model('Message');
        $this->load->model('MessageQueue');
        $this->load->model('msettings');
        $schedule_status = $this->input->post('schedule_status');
        $bs_date = $this->input->post('bs_date');
        $hour = $this->input->post('hour');
        $min = $this->input->post('min');
        $sec = $this->input->post('sec');
        $subject = trim($this->input->post('subject'));
        $txt_message = trim($this->input->post('message'));
        
        $clientId = $this->authenticate->get_client_id();
        
        
        
            $name = $_FILES['numberfile']['name'];
            $type = $_FILES['numberfile']['type'];
            $errors = $_FILES['numberfile']['error'];
            $tmp_name = $_FILES['numberfile']['tmp_name'];
            
            $ext = array();
            $path = 'media'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'csv_numbers'.DIRECTORY_SEPARATOR;
            $filename = $path.$name;
            if(empty($errors))
            {
                $ext = explode("/", (string)$type);
                if(in_array($ext[1],array('csv','comma-separated-values','vnd.ms-excel')))
                {
                    if(file_exists($filename))
                        unlink ($filename);
                    move_uploaded_file($tmp_name, $filename);
                    
                    $fh = fopen($filename,"r");
//                    $row = 0;
//                    echo '<Pre>';
                    $providerInit = array('017','018','019','011','015','016');
                    while(($data = fgetcsv($fh)) !== FALSE)
                    {
                       
                        $mobileNumber = trim($data[0]);
                        
                        $mobileNumber = (preg_match('/^88+/',$mobileNumber))? substr($mobileNumber,2,strlen($mobileNumber)) : $mobileNumber;
                       // $mobileNumber = (preg_match('/^0+/',$mobileNumber))? $mobileNumber : '0'.$mobileNumber;
//                        echo $mobileNumber.'<br/>';
                        if((!empty($mobileNumber)) && (strlen($mobileNumber) == 11) ){
                             
//                            if(preg_match('/^[0-9]{3}$/', $mobileNumber,$providerInit)){
                            
                                $message = new Message();
                                $message->mobileNumber = $mobileNumber;
                                $message->subject = $subject;
                                $message->toWhom = '';
                                $message->message = $txt_message;
                                if($schedule_status)
                                {  
                                    $schedule_time = date("Y-m-d",strtotime($bs_date)). ' '. $hour.':'.$min.':'.$sec;
                                    $message->scheduleTime = $schedule_time;
                                }else{
                                    $message->scheduleTime = "";
                                }
    //                            echo $clientId;
                                $messageQueue =  new MessageQueue();
                                $messageQueue->storeMessage($clientId, $message);
//                            }
                        }
                        $checkDayLimit = $this->messagequeue->checkDayLimit();
                        $dayLimit = $this->messagequeue->getDayLimit();
                        
                        if($checkDayLimit >= $dayLimit)
                        {
                            $header = '';
                            $message = 'Please check your profile. '.$checkDayLimit.' sms waiting for ur approval.';
                            $this->msettings->update(array('value'=>1),array('key'=>'SMS_DAY_LIMIT'));
                            
                            try{
                                
                                mail(MessageQueue::TO,  MessageQueue::SUBJECT, $message,$header);  
                            }
                            catch(Exception $ex)
                            {
                                //
                            }
                        } 
                        
                    }
                    
                   redirect(BASE.'dashboard/sms?error=0#tabs-2');
                    
                }else{
                   redirect(BASE.'dashboard/sms?error=2#tabs-2');
                }
            }
            else
            {
               redirect(BASE.'dashboard/sms?error=1#tabs-2');
            }
    }
    
    /*****sms******/
    
    /*****Maskings****/
    
    public function maskings()
    {
        
        $data = array();
        if(isset($_POST['submitMasking']))
        {
            $this->db->insert('sms_masking',array('masking'=>$this->input->post('masking')));
            redirect(BASE.'dashboard/maskings/');
        }
        $method = $this->uri->segment(2);
        $data['script'] = (!empty($method))? $method : 'no';
        $result = $this->db->get('sms_masking');
        $data['maskings'] = $result->result_array();
        $data['error'] = $this->input->get('error');
        $data['content'] = $this->load->view('maskings/vindex',$data,true);
        $this->layout->set_content($data);
    }
    
    public function delete_masking()
    {
        $masking_id = $this->uri->segment(3);
        if(is_numeric($masking_id)){
            $this->db->where('masking_id',$masking_id);
            $maskingExist = $this->db->count_all_results('sms_masking');
            if($maskingExist)
            {
                $this->db->where('masking_id',$masking_id);
                $this->db->delete('sms_masking');
            }
        }
        redirect(BASE.'dashboard/maskings');
    }
    
    /****Maskings****/
    
    public function regenerate_apikey()
    {
        error_reporting(E_ALL);
        $this->load->model('mdomains');
        if($this->request->is_XmlHttpRequest())
        {
            $domain_id = $this->input->post('domain_id');
            $domainExist = $this->mdomains->tbl_count_where(array('domain_id'=>$domain_id));
               
            if($domainExist){
                
                $result = $this->mdomains->tbl_get(array('domain_id'=>$domain_id));
                $domainInfo = $result;
               
                $domainInfo = (!empty($domainInfo))? array_shift($domainInfo) : array();
                
                if(!empty($domainInfo)){
                    $newKey = $domainInfo['clientId'].sha1('Carbon51'.$domainInfo['name'].time());
                    $this->mdomains->tbl_update(array('key'=>$newKey),array('domain_id'=>$domain_id));
                }
            }
            
        }else{
            redirect(BASE);
        }
    }
    
    public function app_user_details()
    {
       $data = array();
       $domain_id = (int)$this->uri->segment(3);
       $this->load->model('mdomains');
       $result = $this->mdomains->tbl_get(array('domain_id'=>$domain_id));
       $data['domain'] = (!empty($result))? array_shift($result) : array();
       $data['content'] = $this->load->view('settings/vapp_user_details',$data,true);
       $this->layout->set_content($data);
    }

    public function domain_del()
    {
        if($this->request->is_XmlHttpRequest())
        {
            echo $id = $this->input->post('domain_id');
            $this->load->model('mdomains');
            $results = $this->mdomains->tbl_get(array('domain_id'=>$id));
            if(count($results))
            {
                
                $result = array_shift($results);
               
                $clientId = $result['clientId'];
                $this->mdomains->tbl_delete(array('domain_id'=>$result['domain_id']));
                
            }
        }else{
            redirect(BASE);
        }
    }
}

?>
