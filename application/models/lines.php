<?php
/**
 * Created by PhpStorm.
 * User: HimelC51
 * Date: 12/7/14
 * Time: 12:52 PM
 */
require_once APPPATH.'core/MY_adapter.php';
class lines extends MY_adapter{

    protected $table = "lines";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function save($data)
    {

        return $this->tbl_insert($data);
    }



} 