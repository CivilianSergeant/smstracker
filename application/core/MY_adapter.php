<?php
/**
 * Description of madapter
 *
 * @author Himel
 * @property CI_DB $db
 */
class MY_adapter extends CI_Model{
    
    private $table;
    
    
    public function __construct($table) {
        parent::__construct();
        $this->table = $table;
    }
    
    public function tbl_insert($data)
    {
        $this->db->insert($this->table,$data);
        if($this->db->affected_rows() > 0)
        {
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }
    
    public function tbl_get($data=array(),$limit=0,$offset=0)
    {
       
        if(!empty($data))
        {
            foreach($data as $k=>$v)
            {
                if(!empty($data[$k]))
                    $this->db->where($k,$v);
            }
            
        }

        if(!empty($limit))
            $this->db->limit($limit,$offset);
        
        $resource = $this->db->get($this->table);
        $result = $resource->result_array();
        return (!empty($result))? $result : array();
    }
    
    public function query($stmt)
    {
        $resource = $this->db->query($stmt);
        $result = $resource->result_array();
        return (!empty($result))? $result : array();
    }
    
    public function tbl_count()
    {
        return $this->db->count_all($this->table);
    }
    
    public function tbl_count_where($data)
    {
        if(!empty($data))
        {
            foreach($data as $k=>$v)
            {
                if(!empty($data[$k]))
                    $this->db->where($k,$v);
            }
        }
        return $this->db->count_all_results($this->table);
    }
    
    public function tbl_update($data=array(),$where=array())
    {
        $value = array();
        if(!empty($data))
        {
            foreach($data as $k=>$v)
            {
                if(isset($data[$k]))
                {
                    $value[$k] = $v;
                }
            }
        }
        
        $this->db->update($this->table,$value,$where);
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function tbl_delete($data)
    {
        if(!empty($data))
        {
            foreach($data as $k=>$v)
            {
                if(!empty($data[$k]))
                    $this->db->where($k,$v);
            }
            $this->db->delete($this->table);
            if($this->db->affected_rows() > 0)
                    return true;
            else 
                    return false;
        }
        else
        {
            return false;
        }
    }
    
}

?>
