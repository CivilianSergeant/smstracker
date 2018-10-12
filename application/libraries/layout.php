<?php
/**
 * Description of layout
 *
 * @author Himel
 */
class Layout {
    
    private $CI;
    
    private $layouData;
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    public function setLayoutData($data)
    {
        $this->layouData = $data;
    }
    
    public function set_content($data,$layout='')
    {
        $data['balance'] = (!empty($this->layouData))? array_shift($this->layouData) : array();
        $layout = (!empty($layout))?$layout:'layout';
        $this->CI->load->view('Layout/'.$layout,$data);
    }
    
}

?>
