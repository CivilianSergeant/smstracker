<?php
/**
 * Description of credits
 * 
 * 
 * @property Layout $layout
 * @author Himel
 */
class Credits extends CI_Controller{
    
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
        $data = array();
        $data['script'] = 'credits';
        $data['user_type'] = $this->authenticate->get_user_type();
        $getBalance = $this->msms_balance->tbl_get(array('balance_status' => 1));
        $data['balance'] = (!empty($getBalance))? array_shift($getBalance) : array();
        $data['logs'] = $this->msms_balance->get_logs();
        $data['usedBalance'] = $this->getBalanceAvailable();
        $data['content'] = $this->load->view('credits/vindex',$data,true);
        $this->layout->set_content($data);
    }
    
    public function save_balance()
    {
        if($this->request->is_XmlHttpRequest())
        {
            date_default_timezone_set('Asia/Dhaka');
            $exist = $this->msms_balance->isExist(array(
                'provider' => $this->input->post('provider',true),
                'balance_status' => 1,
            ));
            if($exist)
            {
                $getBalance = $this->msms_balance->tbl_get(array('provider' => $this->input->post('provider',true),'balance_status' => 1));
                if(!empty($getBalance)){
                    $availableBalance = array_shift($getBalance);
                    $newAvailableBalance = ($this->input->post('deposite_amount',true) + $availableBalance['balance_available']);
                    
                    $saved = $this->msms_balance->save(array(
                        'provider' => $this->input->post('provider',true),
                        'balance_deposite' => $newAvailableBalance,
                        'balance_available' => $newAvailableBalance,
                        'balance_added' =>$this->input->post('deposite_amount',true),
                        'deposite_dt' => date("Y-m-d H:i:s"),
                        'balance_status' => 1
                    ));
                    
                    $updatedOldRecord = $this->msms_balance->tbl_update(array(
                        'balance_status' => 0
                    ),array('sms_balance_id'=>$availableBalance['sms_balance_id']));
                }
            }
            else
            {
                $saved = $this->msms_balance->save(array(
                    'provider' => $this->input->post('provider',true),
                    'balance_deposite' => $this->input->post('deposite_amount',true),
                    'balance_available' => $this->input->post('deposite_amount',true),
                    'balance_added' => $this->input->post('deposite_amount',true),
                    'deposite_dt' => date("Y-m-d"),
                    'balance_status' => 1
                ));
            }
            
        }
        else
        {
            redirect(BASE);
        }
    }
    
     public function getBalanceAvailable()
    {
        $ch = curl_init();
        $url = 'http://eworldbd.com/API/Service.asmx';
        
        $postData = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <Balance xmlns="http://tempuri.org/">
              <username>carbon</username>
              <password>ew51</password>
            </Balance>
          </soap12:Body>
        </soap12:Envelope>';

        // Set url
        curl_setopt($ch, CURLOPT_URL , $url);
        
        // set Request Header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/soap+xml; charset=utf-8','Content-Length:'.strlen($postData)));
        // set Post Data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        
        // Return the transfer as string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $output = curl_exec($ch);
        curl_close($ch);
        
        $doc = new DOMDocument();
        $doc->loadXML($output);
        $balanceResults = $doc->getElementsByTagName('BalanceResult');
        return $balanceResults->item(0)->nodeValue;
    }
    
}

?>
