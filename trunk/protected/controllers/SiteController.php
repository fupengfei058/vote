<?php

class SiteController extends Controller
{
    public function actionIndex()
    {
        $model = new Contestant;
        $contestant = $model->findAll();
        $this->renderPartial('index',array('contestant'=>$contestant));
    }

    public function actionVote(){
        echo $_POST['contestantId'];
        //$contestant = Contestant::
    }

}