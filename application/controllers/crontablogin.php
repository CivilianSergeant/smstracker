<?php
/**
 * Created by PhpStorm.
 * User: Himel
 * Date: 3/30/14
 * Time: 10:36 AM
 */

require_once APPPATH.'core/Providers/Eworld.php';
class crontablogin extends CI_Controller{

    public function __construct() {

        parent::__construct();


    }

    public function index()
    {
        $this->load->model('msettings');
        $settings = $this->msettings->get_settings(array('key'=>'notification'));
        $settingsActiveVendor = $this->msettings->get_settings(array('key'=>'active_vendor'));
        $email = $this->msettings->get_settings(array('key'=>'email'));


        $provider = new Eworld();
        try{
            $result = $provider->getBalanceAvailable();
            if(preg_match('/Invalid User Name Or Password/',$result))
            {

                if($settings['value'] != 'Send')
                {
                    //$this->msettings->update(array('value'=>'BulkSms'),array('key'=>'active_vendor'));
                    $to = (!empty($email['value']))? trim($email['value']) : 'info@carbon51.com';
                    $subject = 'SMS TRACKER C51 : SMS Sending Failed. Please Change SMS Provider FROM '.$settingsActiveVendor['value']. ' to BulkSms';
                    $msg = 'SMS Sending Failed, Please Contact with Provider';
                    $headers = 'From: no-reply@carbon51.com';
                    mail($to,$subject,$msg,$headers);
                }

                $this->msettings->update(array('value'=>'Send'),array('key'=>'notification'));

            }
            else
            {
                if($settings['value'] != 'OK')
                {
                    //$this->msettings->update(array('value'=>'Eworld'),array('key'=>'active_vendor'));
                    $to = (!empty($email['value']))? trim($email['value']) : 'info@carbon51.com';
                    $subject = 'SMS TRACKER C51 : SMS Sending Now. Please Change SMS Provider FROM '.$settingsActiveVendor['value']. ' to Eworld';
                    $msg = 'SMS Sending Now, System now sending sms normally';
                    $headers = 'From: no-reply@carbon51.com';
                    mail($to,$subject,$msg,$headers);
                }

                $this->msettings->update(array('value'=>'OK'),array('key'=>'notification'));
            }
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }

    }



}