<?php
class record extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return "vote_record";
    }

    //根据ip和活动ID获取投票记录
    public function getRecord($data = [])
    {
        return $this->findAll("itemId=:itemId and IP=:IP",array(":itemId"=>$data['itemId'],":IP"=>$data['ip']));
    }

    //进行投票
    public function voteOpration($recordParams = [],$itemParams = [],$contestantParams = [])
    {
        $transaction = $this->dbConnection->beginTransaction();
        try {
            //Yii::beginProfile('block1');
            //1.生成投票记录
            $this->itemId = $recordParams['itemId'];
            $this->contestantId = $recordParams['contestantId'];
            $this->voteTime = $recordParams['voteTime'];
            $this->IP = $recordParams['ip'];
            $this->save();
            //2.活动投票量增加1
            Yii::app()->db->createCommand("update vote_item set `totalVote`=`totalVote`+1 where itemId={$itemParams['itemId']}")->execute();
            //3.选手票数增加1
            Yii::app()->db->createCommand("update vote_contestant set `voteCount`=`voteCount`+1 where contestantId={$contestantParams['contestantId']}")->execute();
            //Yii::endProfile('block1');
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
