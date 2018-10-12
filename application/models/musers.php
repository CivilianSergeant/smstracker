<?php
/**
 * Description of muser
 *
 * @author Himel
 */
require_once APPPATH.'core/MY_adapter'.EXT;
class Musers extends MY_adapter{
    
    private $table = "users";
    
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
    
    public function getClientList()
    {
        $sql = "SELECT DISTINCT clientId,user_name From ".$this->table;
        //." WHERE user_type='client'";
        return $this->query($sql);
    }
    
    public function count_users()
    {
        $this->db->where('user_type !=','super_admin');
        return $this->db->count_all_results($this->table);
    }
    
    public function get_user($clientId){
        $this->db->where('clientId',$clientId);
        $result = $this->db->get($this->table);
        return $result->result_array();
    }
    
    public function get_users($data=array(),$limit,$offset)
    {
        // for hidding super_admin
        $this->db->where('user_type !=','super_admin');
        
        return $this->tbl_get($data,$limit,$offset);
    }
    
    public function delete($data)
    {
        return $this->tbl_delete($data);
    }
    
}

?>
