<?php
/**
 * Description of mbalance_deducted
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter.php';
class Mbalance_deducted extends MY_adapter{
    
    protected $table = 'balance_deducted';
    
    public function __construct() {
        parent::__construct($this->table);
    }
    
    public function save($data)
    {
        return $this->tbl_insert($data);
    }
    
}

?>
