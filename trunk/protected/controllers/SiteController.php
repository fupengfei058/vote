<?php

class SiteController extends Controller
{

    //首页
    public function actionIndex()
    {
        $this->render('index',array('contestant'=>$this->contestant));
    }

    //投票
    public function actionVote()
    {
        //http://1.vote.yaochufa.com
        if (isset($_POST['contestantId'])) {
            $recordModel = new Record();
            //判断IP是否已投过票
            $ip = $_SERVER["REMOTE_ADDR"];
            $data = [
                'ip' => ip2long($ip),
                'itemId' => $_SESSION['itemId']
            ];
            //根据ip和活动ID获取投票记录
            $record = $recordModel->getRecord($data);
            if (!empty($record)) {
                exit(json_encode(array('code'=>-1,'message'=>"不能重复投票")));
            }
            $recordParams = [
                'itemId' => $_SESSION['itemId'],
                'contestantId' => $_POST['contestantId'],
                'voteTime' => time(),
                'ip' => ip2long($ip)
            ];
            $itemParams = [
                'itemId' => $_SESSION['itemId']
            ];
            $contestantParams = [
                'contestantId' => $_POST['contestantId']
            ];
            //进行投票
            $result = $recordModel->voteOpration($recordParams,$itemParams,$contestantParams);
            if($result){
                exit(json_encode(array('code'=>1000,'message'=>"投票成功")));
            }else{
                exit(json_encode(array('code'=>-1,'message'=>"投票失败")));
            }
        }
        exit(json_encode(array('code'=>-1,'message'=>"投票失败")));
    }
}
