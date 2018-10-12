<?php
/**
 * Description of mdomains
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter.php';

class Mdomains extends MY_adapter{
   
    protected $table = "domain";

    public function __construct() {
        parent::__construct($this->table);
    }
    
    public function save($data)
    {
        
       return $this->tbl_insert($data);
    }
    
    public function getClientList()
    {
        $sql = "SELECT DISTINCT clientId, name as user_name From ".$this->table;
        //." WHERE user_type='client'";
        return $this->query($sql);
    }
}

?>
