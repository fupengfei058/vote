<?php
class contestant extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function tableName()
    {
        return "vote_contestant";
    }

    public function attributeLabels()
    {
        return array();
    }

    public function rules()
    {
        return array(
            array('contestantName','required','message'=>'选手名称不能为空'),
            array('mobile','required','message'=>'联系电话不能为空'),
            array('mobile','numerical','message'=>'联系电话不合法'),
            array('pic',
                 'file',
                 'allowEmpty'=>true,
                 'types'=>'png,jpeg,jpg,gif',
                 'maxSize'=>1024*1024*2,
                'tooLarge'=>'图片不能大于2M',
            ),
            array('desc','required','message'=>'描述不能为空')
        );
    }

    //文件上传
    public function upload($file)
    {
        $filename = $file->getName();
        $uploaddir = Yii::app()->basePath.'/runtime/upload';
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir,777);
        }
        $uploadfile = $uploaddir.'/'.time().$filename;
        if ($file->saveAs($uploadfile,true)) {
            return $uploadfile;
        } else {
            return false;
        }
    }
}
