<?php
/**
 * Description of msettings
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter.php';
class msettings extends MY_adapter{
    
    private $table = "settings";
    
    public function __construct() {
        parent::__construct($this->table);
    }
    
    public function save($data)
    {
        return $this->tbl_insert($data);
    }
    
    public function get_settings($data)
    {
       $result = $this->tbl_get($data);
       return (!empty($result))? array_shift($result) : array();
    }
    
    public function isExist($data)
    {
        return $this->tbl_count_where($data);
    }
    
    public function update($data,$key)
    {
       return $this->tbl_update($data,$key);
    }
    
}

?>
