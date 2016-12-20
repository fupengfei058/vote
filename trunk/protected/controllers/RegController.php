<?php

class RegController extends Controller
{

    //异步检查报名是否截止
    public function actionCheckReg()
    {
        $item = Item::model()->findByPk($_SESSION['itemId']);
        if ($item->regEndTime < time()) {
            exit(json_encode(array('code'=>-1,'message'=>"报名已经截止")));
        }
    }

    //报名
    public function actionReg()
    {
        $model = new Contestant;
        if (!empty($_POST['Contestant'])) {
            $model->attributes = $_POST['Contestant'];
            if ($model->validate()) {
                $file = CUploadedFile::getInstance($model,'pic');
                if (is_object($file) && get_class($file) === 'CUploadedFile') {
                    //创建文件目录
                    $fileDir = Yii::app()->basePath.'/runtime/upload';
                    if (!is_dir($fileDir)) {
                        mkdir($fileDir,0777);
                    }
                    $model->pic = $fileDir.'/'.time().'_'.rand(0,9999).'.'.$file->extensionName;
                    $model->itemId = $_SESSION['itemId'];
                    //查找本次活动中最大的编号+1作为该选手的编号
                    $maxSortNum = Yii::app()->db->createCommand("select max(sortNum) from {Contestant::tableName} where itemId={$_SESSION['itemId']}")->queryScalar();
                    $model->sortNum = $maxSortNum ? ($maxSortNum + 1) : 1;
                    $model->voteCount = 0;
                    $model->createTime = time();
                    if ($model->save()) {
                        $file->saveAs($model->pic);
                        $this->redirect('/index.php?r=site/index');
                    }
                }
            }
        }
        $this->render('reg',array('model'=>$model));
    }
}
