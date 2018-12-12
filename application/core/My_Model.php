<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * model基类
 * @author Toby.Tu 2016-04-19
 */
class My_Model extends CI_Model{
    protected $start_update_log = true;//是否开启字段修改日志
    protected $current_id = 0;//当前登录用户的id
	function __construct(){
		parent::__construct();
		$this->load->database();
		if(method_exists($this,'init')){//默认执行的方法
			$this->init();
		}
	}
    /**
     * 新增数据
     * @author Toby.tu 2016-09-12
     */
    public function newData($param=array(),$tab=''){
        if(empty($tab)) $tab = $this->getTab();
        if(empty($param) || empty($tab)) return false;
        $this->db->insert($tab, $param);
        return $this->db->insert_id();
    }
    /**
     * 修改数据
     * @author Toby.tu 2016-09-12
     */
    public function updateById($id=0,$param=array(),$tab='',$pk='',$start_update_log = true){
        if(empty($tab)) $tab = $this->getTab();
        if(empty($id) || empty($param) || empty($tab)) return false;
		if(empty($pk)) $pk = $this->getPk();
//		$this->start_update_log = $start_update_log;
        if($start_update_log){
            $this->load->model('Sensitive_model','sensitive_model');
            $this->sensitive_model->write_log($tab,$id,$param,$pk,1);
        }
        $bool = $this->db->where($pk,$id)->update($tab, $param);

        return $this->db->affected_rows();  //影响行数
    }
    /**
     * 修改数据
     * @author Toby.tu 2016-09-12
     */
    public function updateInId($id=array(),$param=array(),$tab='',$pk=''){
        if(empty($tab)) $tab = $this->tab;
        if(empty($id) || empty($param) || empty($tab)) return false;
        if(empty($pk)){
            if(isset($this->pk)){
                $pk = $this->pk;
            }else{
                $pk = 'id';
            }
        }
        $bool = $this->db->where_in($pk,$id)->update($tab, $param);
        return $this->db->affected_rows();  //影响行数
    }
    /**
     * 获取当前模块的主键
     * @author Toby.tu 2016-10-19
     */
    public function getPk(){
        if(isset($this->pk)){
            return $this->pk;
        }else{
            return 'id';
        }
    }
    /**
     * 获取表名
     * @author Toby.tu 2016-10-21
     */
    public function getTab(){
        if(isset($this->tab)){
            return $this->tab;
        }else{
            $modelname = get_class($this);
            $modelname = sprintf('%s',$modelname);
            $modelname = trim($modelname,'_model');
            return strtolower($modelname);
        }
    }
    /**
     * 获取带前缀的表名
     * @author Toby.tu 2017-03-01
     */
    public function getTabName(){
        $tab = $this->getTab();
        return $this->db->dbprefix.$tab;
    }
    /**
     * 获取全部，但只能获取1000条，更多的数据不建议用这个方法
     * @author Toby.tu 2016-09-02
     */
    public function getAll($tab=''){
		if(empty($tab)) $tab = $this->getTab();
        $query = $this->db->select('*')->where('deleted',0)
                    ->order_by('update_time desc')->limit(1000)->get($tab);
        if(!empty($query)){
            return $query->result_array();
        }
        return array();
    }
    /**
     * 获取一条
     * @author Toby.tu 2016-10-08
     */
    public function getOne($param=array(),$tab=''){
        if(empty($tab) || empty($param)) $tab = $this->getTab();
        $this->db->select('*');
        foreach ($param as $fld => $val) {
            if(empty($fld)) $fld = $this->getPk();
            $this->db->where($fld,$val);
        }
        $query = $this->db->limit(1)->get($tab);
        if(!empty($query)){
            return $query->row_array();
        }
        return array();
    }
    /**
     * 查询
     * @author Toby.tu 2016-10-19
     */
    public function select($field){
        $tab = $this->getTab();
        $field = strtr($field, array('_tab'=>$tab));
        $this->db->select($field);
        return $this->db;
    }
    /**
     * 获取数据
     * @author Toby.tu 2016-10-19
     */
    public function get($fld=''){
        $tab = $this->getTab();
        $query = $this->db->get($tab);
        if(!empty($query)){
            $rows = $query->result_array();
            if(empty($fld)){
                return $rows;
            }else{
                $list = array();
                foreach ($rows as $row) {
                    if(!isset($row[$fld])){
                        break;
                    }
                    $list[$row[$fld]] = $row;
                }
                if(!empty($list)) return $list;
                return $rows;
            }
        }
        return array();
    }
    /**
     * 获取单条数据
     * @author Toby.tu 2016-10-19
     */
    public function getRow(){
        $tab = $this->getTab();
        $query = $this->db->get($tab);
        if(!empty($query)){
            $rows = $query->row_array();
            return $rows;
        }
        return array();
    }
	/**
     * 导入类库
     * @author Toby.tu 2016-08-31
     */
    public function vendor($clsname,$nickname=''){
        $clsname = strtr($clsname,['@.'=>'models/','$.'=>'logic/']);
        if(empty($nickname)){
            $clsarr = explode('/', $clsname);
            $nickname = strtolower($clsarr[count($clsarr)-1]);
        }
        $this->load->model('../'.$clsname,$nickname);
    }

    /**
     * 删除数据
     * @author Toby.tu 2016-09-12
     */
    public function deleteById($id=0,$tab='',$pk=''){
        if(empty($tab)) $tab = $this->getTab();
        if(empty($pk)) $pk = $this->getPk();
        $this->db->where($pk,$id)->delete($tab);
        return $this->db->affected_rows();  //影响行数
    }

}
?>
