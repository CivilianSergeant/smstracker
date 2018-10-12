<?php
/**
 * Description of msms_limit
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter.php';
class Msms_limit extends MY_adapter{
    
    protected $table = "sms_limit";
    
    public function __construct() {
        parent::__construct($this->table);
    }
    
    public function save($data)
    {
       return $this->tbl_insert($data);
    }
    
    public function isExist($data)
    {
        return $this->tbl_count_where($data);
    }
    
    public function getLimits()
    {
        $this->load->model('mdomains');
        $domains = $this->mdomains->query('SELECT *,domain.domain_id as did FROM domain 
LEFT JOIN sms_limit ON domain.domain_id = sms_limit.domain_id
');
        $results = array();
        if(!empty($domains))
        {
            foreach($domains as $k=> $domain)
            {
                $response[$k]['studentsCount'] = @file_get_contents($domain['link'].'/get_reg_students_count/');
                $response[$k]['schoolInfo'] = $domain;
            }
            return $results=$response;
        }
        
    }
    
    
}

?>
