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
}
