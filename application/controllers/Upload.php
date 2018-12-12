<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/15
 * Time: 17:53
 */

//上传
class Upload extends My_Controller {
    private $assign;

    private $uploadDir = "upload/";
    public function __construct()
    {
        parent::__construct();
    }

    //上传图片
    public function uploadFile()
    {


        try {

            if (empty($_FILES)){
                $this->responseJson(1003,'请检查文件大小或不支持的文件');
            }
            //获取后缀
            $pointLocation = strrpos($_FILES['file']['name'],'.');
            $fileSuffix = substr($_FILES['file']['name'], $pointLocation+1);


            if (in_array($fileSuffix,config_item('image_upload_file')['allowType']) ){
                $filetype= config_item('image_upload_file');
            } elseif (in_array($fileSuffix,config_item('audio_upload_file')['allowType'])) {
                $filetype= config_item('audio_upload_file');
            }

            if (empty($filetype)){
                $this->responseJson(1003,'不支持的文件类型');
            }

            $filePath = $this->uploadFormData('file',$this->uploadDir, $filetype['allowType'],true,$filetype['size']);
            if (!$filePath){
                $this->responseJson(1003,'图片上传失败');
            }

            $input['file_path'] = base_url()."upload/".$filePath;


            $this->responseJson(200,'success',$input);

        } catch (\Exception $e) {
            $this->responseJson(10037,$e->getMessage());
        }
    }

    public function uploadFormData($fileName, $uploadDir, $allowType, $imagePrefix = true,$maxsize='')
    {
        $this->load->library('Uploads');
        $params = [
            'randName' => $imagePrefix,
            'allowType' => $allowType,
            'FilePath' => $uploadDir,
            'MAXSIZE' => $maxsize,
            'isgroup' => true
        ];


        $objFileUpload = new Uploads($params);

        if (!$objFileUpload->uploadFile($fileName)) {

            throw new \Exception($objFileUpload->getErrorMsg(), 10004);
        }

        return $objFileUpload->getPathName();
    }

}