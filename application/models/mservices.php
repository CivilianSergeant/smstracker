<?php
/**
 * Description of mservices
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter.php';
class Mservices extends MY_adapter{
    
    private $link;
    private $dateFrom;
    private $dateTo;
    
    public function __construct() {
        $this->load->model('mdomains');
    }
    
    public function init($param="",$param1="",$param2="")
    {
        $this->link = $param;
        $this->dateFrom = (!empty($param1))? date("Y-m-d",strtotime($param1)):'';
        $this->dateTo = (!empty($param2))? date("Y-m-d",strtotime($param2)) : '';
    }
    
    public function get_domains()
    {
        return $this->mdomains->tbl_get();
    }
    
    public function get_report_summary($duration=0,$today='')
    {
       
        if(!empty($this->dateFrom) && !empty($this->dateTo))
        {
            $domains = $this->get_domains();
            $result = array();
            if(!empty($domains))
            {
                $response = '';
                foreach($domains as $domain)
                {
                    if(!empty($this->link))
                    {
                        if($this->link == $domain['link']){
                            $result[$domain['name']]['Link'] = $domain['link'];
                            
                            $response = @file_get_contents($domain['link'].'/count_report_between_date/'.$this->dateFrom.'/'.$this->dateTo);
                            

                            $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                            $result[$domain['name']]['Count'] = (!empty($response))? json_decode($response) : 'link error';
                            break;
                        }
                    }else{
                        $result[$domain['name']]['Link'] = $domain['link'];
                        
                        $response = @file_get_contents($domain['link'].'/count_report_between_date/'.$this->dateFrom.'/'.$this->dateTo);
                        

                        $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                        $result[$domain['name']]['Count'] = (!empty($response))? json_decode($response) : 'link error';
                    }  
                }
            }
            return $result;
            
        }
        else if(!empty($duration))
        {
            $domains = $this->get_domains();
            $result = array();
            if(!empty($domains))
            {
                $response = '';
                foreach($domains as $domain)
                {
                    if(!empty($this->link))
                    {
                        if($this->link == $domain['link']){
                            $result[$domain['name']]['Link'] = $domain['link'];
                            
                            $response = @file_get_contents($domain['link'].'/count_report_by_duration/'.$duration);
                            

                            $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                            $result[$domain['name']]['Count'] = (!empty($response))? json_decode($response) : 'link error';
                            break;
                        }
                    }else{
                        $result[$domain['name']]['Link'] = $domain['link'];
                        
                        $response = @file_get_contents($domain['link'].'/count_report_by_duration/'.$duration);
                        

                        $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                        $result[$domain['name']]['Count'] = (!empty($response))? json_decode($response) : 'link error';
                    }  
                }
            }
            return $result;
        }
        else
        { 
            $domains = $this->get_domains();
            $result = array();
            if(!empty($domains))
            {
                $response = '';
                foreach($domains as $domain)
                {
                    if(!empty($this->link))
                    {
                        if($this->link == $domain['link']){
                            $result[$domain['name']]['Link'] = $domain['link'];
                            if(!empty($today))
                            {
                                date_default_timezone_set('Asia/Dhaka');
                                $response = @file_get_contents($domain['link'].'/count_report_today/'.date('Y-m-d'));
                            }
                            else
                            {
                                $response = @file_get_contents($domain['link'].'/count_report_all');
                            }

                            $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                            $result[$domain['name']]['Count'] = (!empty($response))? json_decode($response) : 'link error';
                            break;
                        }
                    }else{
                        $result[$domain['name']]['Link'] = $domain['link'];
                        if(!empty($today))
                        {
                            date_default_timezone_set('Asia/Dhaka');
                            $response = @file_get_contents($domain['link'].'/count_report_today/'.date('Y-m-d'));
                        }
                        else
                        {
                            $response = @file_get_contents($domain['link'].'/count_report_all');
                        }

                        $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                        $result[$domain['name']]['Count'] = (!empty($response))? json_decode($response) : 'link error';
                    }  
                }
            }
            return $result;
        }
  
    }
    
    
    public function get_report_details($duration=0,$today='')
    {
       
        if(!empty($this->dateFrom) && !empty($this->dateTo))
        {
            $domains = $this->get_domains();
            $result = array();
            if(!empty($domains))
            {
                $response = '';
                foreach($domains as $domain)
                {
                    if(!empty($this->link))
                    {
                        if($this->link == $domain['link']){
                            $result[$domain['name']]['Link'] = $domain['link'];
                            
                            $response = @file_get_contents($domain['link'].'/get_report_between_date/'.$this->dateFrom.'/'.$this->dateTo);
                            

                            $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                            $result[$domain['name']]['Details'] = (!empty($response))? json_decode($response) : array();
                            break;
                        }
                    }else{
                        $result[$domain['name']]['Link'] = $domain['link'];
                        
                        $response = @file_get_contents($domain['link'].'/get_report_between_date/'.$this->dateFrom.'/'.$this->dateTo);
                        

                        $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                        $result[$domain['name']]['Details'] = (!empty($response))? json_decode($response) : array();
                    }  
                }
            }
            return $result;
            
        }
        else if(!empty($duration))
        {
            $domains = $this->get_domains();
            $result = array();
            if(!empty($domains))
            {
                $response = '';
                foreach($domains as $domain)
                {
                    if(!empty($this->link))
                    {
                        if($this->link == $domain['link']){
                            $result[$domain['name']]['Link'] = $domain['link'];
                            
                            $response = @file_get_contents($domain['link'].'/get_report_by_duration/'.$duration);
                            

                            $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                            $result[$domain['name']]['Details'] = (!empty($response))? json_decode($response) : array();
                            break;
                        }
                    }else{
                        $result[$domain['name']]['Link'] = $domain['link'];
                        
                        $response = @file_get_contents($domain['link'].'/get_report_by_duration/'.$duration);
                        

                        $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                        $result[$domain['name']]['Details'] = (!empty($response))? json_decode($response) : array();
                    }  
                }
            }
            return $result;
        }
        else
        { 
            $domains = $this->get_domains();
            $result = array();
            if(!empty($domains))
            {
                $response = '';
                foreach($domains as $domain)
                {
                    if(!empty($this->link))
                    {
                        if($this->link == $domain['link']){
                            $result[$domain['name']]['Link'] = $domain['link'];
                            if(!empty($today))
                            {
                                date_default_timezone_set('Asia/Dhaka');
                                $response = @file_get_contents($domain['link'].'/get_report_today/'.date('Y-m-d'));
                            }
                            else
                            {
                                $response = @file_get_contents($domain['link'].'/get_report_all');
                            }

                            $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                            $result[$domain['name']]['Details'] = (!empty($response))? json_decode($response) : array();
                            break;
                        }
                    }else{
                        $result[$domain['name']]['Link'] = $domain['link'];
                        if(!empty($today))
                        {
                            date_default_timezone_set('Asia/Dhaka');
                            $response = @file_get_contents($domain['link'].'/count_report_today/'.date('Y-m-d'));
                        }
                        else
                        {
                            $response = @file_get_contents($domain['link'].'/count_report_all');
                        }

                        $result[$domain['name']]['Status'] = (!empty($response))? 200 : 500;
                        $result[$domain['name']]['Details'] = (!empty($response))? json_decode($response) : array();
                    }  
                }
            }
            return $result;
        }
  
    }
    
    
    
}

?>
