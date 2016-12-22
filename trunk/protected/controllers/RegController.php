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
        $model = new Contestant();
        if (!empty($_POST['contestant'])) {
            $model->attributes = $_POST['contestant'];
            if ($model->validate()) {
                $file = CUploadedFile::getInstance($model,'pic');
                $itemId = $_SESSION['itemId'];
                if($model->upload($file,$itemId)){
                    $this->redirect('/index.php?r=site/index');
                }
            }
        }
        $this->render('reg',array('model'=>$model));
    }
}
