<?php

/**
 * Description of mcsms_limit
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter.php';
class Mcsms_limit extends MY_adapter{
    
    
    protected $table = "client_sms_limit";
    
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
    
    
    
}

?>
