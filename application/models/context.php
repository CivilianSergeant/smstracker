<?php
/**
 * Created by PhpStorm.
 * User: HimelC51
 * Date: 12/7/14
 * Time: 3:28 PM
 */

class Context extends CI_Model{

    public $subject;
    public $number;
    public $provider;
    public $line;

    public function setData($sub,$num)
    {

        $this->subject = $sub;
        $this->number  = $num;
    }

    public function getLineNumber()
    {
        $this->load->model('lines');
        $this->load->model('msettings');
        $provider = $this->determineProviderByNumber();
        $defaultLine = $this->lines->tbl_get(array('masking'=>$this->subject,'provider'=>'Default','active'=>1));

        $vendor  = $this->lines->tbl_get(array('masking'=>$this->subject,'provider'=>$provider,'active'=>1));
        $vendor = array_shift($vendor);



        if($vendor['line_number'] == "OFF")
        {
            return null;

        }else if($vendor['line_number'] == "Default")
        {
            if($defaultLine>0)
            {
                $line = array_shift($defaultLine);
                if($line['line_number'] != "OFF"){
                    return $line['line_number'];
                }else{
                    return null;
                }
            }else{
                return null;
            }

        }else{
            $this->line = $vendor['line_number'];
            return $vendor['line_number'];

        }
        return null;
    }

    public function getSubject($provider)
    {
        if(in_array($this->subject,$provider->getMaskList()))
        {
            return $this->subject;
        }

        /*else{
            // for non masked provider
            if($this->subject == "MPCC")
                return "College";
            else if($this->subject = "CBC")
                return "College";
            else
                return "School";
        }*/

    }

    protected function determineProviderByNumber($number = ''){

        $this->number = (empty($number))? $this->number :  $number;

        if(preg_match('/^017/',$this->number))
        {
            $this->provider = "GP";

        }else if(preg_match('/^016/',$this->number))
        {
            $this->provider = "AIRTEL";


        }else if(preg_match('/^019/',$this->number))
        {
            $this->provider = "BLINK";

        }else if(preg_match('/^018/',$this->number))
        {
            $this->provider = "ROBI";

        }else if(preg_match('/^015/',$this->number))
        {
            $this->provider = "TELETALK";

        }else if(preg_match('/^011/',$this->number))
        {
            $this->provider = "CITYCELL";
        }
        return $this->provider;
    }


} 