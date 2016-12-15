<?php

class SiteController extends Controller
{
    //首页
    public function actionIndex()
    {

        //选手信息
        $contestant = Contestant::model()->findAllBySql('select * from vote_contestant where itemId=? order by voteCount desc',array($_SESSION['voteId']));
        $contestant = json_decode(CJSON::encode($contestant),TRUE);
        //报名人数
        $contestantNumbers = count($contestant);
        //活动信息
        $item = Item::model()->findByPk($_SESSION['itemId']);
        $this->renderPartial('home',array('contestant'=>$contestant,'item'=>$item,'contestantNumbers'=>$contestantNumbers));
    }

    //投票
    public function actionVote()
    {
        //http://1.vote.yaochufa.com
        if(isset($_POST['contestantId'])){
            $recordModel = new Record;
            //1.判断IP是否已投过票
            $ip = $_SERVER["REMOTE_ADDR"];
            $record = $recordModel->findAll("itemId=:itemId and IP=:IP",array(":itemId"=>$_SESSION['itemId'],":IP"=>ip2long($ip)));
            if(!empty($record)){
                exit(json_encode(array('code'=>-1,'message'=>"不能重复投票")));
            }
            $transaction = $recordModel->dbConnection->beginTransaction();
            try
            {
                //Yii::beginProfile('block1');
                //2.生成投票记录
                $recordModel->itemId = $_SESSION['itemId'];
                $recordModel->contestantId = $_POST['contestantId'];
                $recordModel->voteTime = time();
                $recordModel->IP = ip2long($ip);
                $recordModel->save();
                //3.活动投票量增加1
                Yii::app()->db->createCommand("update vote_item set `totalVote`=`totalVote`+1 where itemId={$_SESSION['itemId']}")->execute();
                //Yii::endProfile('block1');
                //4.选手票数增加1
                Yii::app()->db->createCommand("update vote_contestant set `voteCount`=`voteCount`+1 where contestantId={$_POST['contestantId']}")->execute();
                $transaction->commit();
                exit(json_encode(array('code'=>1000,'message'=>"投票成功")));
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                exit(json_encode(array('code'=>-1,'message'=>"投票失败")));
            }
        }
        exit(json_encode(array('code'=>-1,'message'=>"投票失败")));
    }

    //报名
    public function actionReg()
    {
        if(!empty($_POST)){


        }
        $this->renderPartial('reg');
    }

}