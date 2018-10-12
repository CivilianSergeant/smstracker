<?php
/**
 * Created by PhpStorm.
 * User: HimelC51
 * Date: 12/7/14
 * Time: 12:27 PM
 */

require_once APPPATH.'core/MY_adapter.php';

class Sms_masking extends MY_adapter{

    protected $table = "sms_masking";

    public function __construct() {
        parent::__construct($this->table);
    }
} 