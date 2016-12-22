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
    public function upload($file,$itemId)
    {
        if (is_object($file) && get_class($file) === 'CUploadedFile') {
            //创建文件目录
            $fileDir = Yii::app()->basePath.'/runtime/upload';
            if (!is_dir($fileDir)) {
                mkdir($fileDir,0777);
            }
            $this->pic = $fileDir.'/'.time().'_'.rand(0,9999).'.'.$file->extensionName;
            $this->itemId = $_SESSION['itemId'];
            //查找本次活动中最大的编号+1作为该选手的编号
            $maxSortNum = Yii::app()->db->createCommand("select max(sortNum) from vote_contestant where itemId={$itemId}")->queryScalar();
            $this->sortNum = $maxSortNum ? ($maxSortNum + 1) : 1;
            $this->voteCount = 0;
            $this->createTime = time();
            if ($this->save()) {
                $file->saveAs($this->pic);
                return true;
            }
        }
        return false;
    }
}
