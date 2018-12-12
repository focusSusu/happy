<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 14:04
 */

class Category_model extends My_Model
{

    public $tab = 'class_category';
    public $pk = 'id';
    public function __construct()
    {
        parent::__construct();
    }
}