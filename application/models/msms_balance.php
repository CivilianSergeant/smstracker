<?php
/**
 * Description of msms_balance
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter.php';
class Msms_balance extends MY_adapter{
    
    protected $table = 'sms_balance';

    public function __construct() {
        parent::__construct($this->table);
    }
    
    public function save($data)
    {   
        $this->db->trans_start();
        $result = $this->tbl_insert($data);
        $this->db->trans_complete();
        return $result;
    }
    
    public function get_logs()
    {
        $stmt = "SELECT * FROM((SELECT balance_added as AMOUNT,balance_status AS TRANS_STATUS, deposite_dt as TRANS_DATE FROM sms_balance)UNION DISTINCT
        (SELECT amount_deducted as AMOUNT, deduction_status AS TRANS_STATUS, transaction_dt as TRANS_DATE FROM balance_deducted)) as mytbl ORDER BY mytbl.TRANS_DATE DESC";
    
        return $this->query($stmt);
    }
    
    public function isExist($data)
    {
        return $this->tbl_count_where($data);
    }
    
}

?>
