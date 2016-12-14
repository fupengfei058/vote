<?php
/**
 * Created by PhpStorm.
 * User: fupengfei
 * Date: 2016/12/9
 * Time: 11:54
 */
class Contestant extends CActiveRecord{

    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return "vote_contestant";
    }

    public function attributeLabels() {
        return array(
            "contestantName"=>"选手名称",
            "mobile"=>"电话",
            "email"=>"邮箱",
            "sex"=>"性别",
            "picList"=>"图片",
            "desc"=>"选手描述"
        );
    }

    public function rules() {
        return array(
            array("contestantName","required","message"=>"选手名称不能为空"),
            array("mobile",'length', 'max'=>13,"message"=>"号码长度不正确"),
            array('email','safe'),  //只有设置了验证规则才可以被attributes接收
            array("sex","in","range"=>array(1,2),"message"=>"性别有误"),
            //array("picList","required","message"=>"图片不能为空"),
            array("desc","required","message"=>"选手描述不能为空"),
        );

        //Email验证器
        //array('email','email'); //验证email这个字段必须符合email格式

        //Compare验证器
        //array('password2','compare','compareAttribute'=>'password1'),//验证password1和password2必须一致
        //array('end_date','compare', 'compareAttribute' => 'start_date', 'operator' => '>', 'message' => '错误的开始结束日期'),

        //Unique验证器
        //array('username,email','unique','className'=>'User'),//User为Model,username,email在user中不允许重复

        //array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),

        //布尔验证器
        //array('rememberMe', 'boolean'),

        //数字验证器
        //array('id', 'numerical', 'min'=>1, 'max'=>10, 'integerOnly'=>true),

        //default验证器
        //array('created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false)

        //fiter验证器
        //array('moduleID', 'filter', 'filter'=>'trim'),

        //正则验证器
        //array('name','match','pattern'=>'/^[a-z0-9\-_]+$/'),

        //in验证器
        //array('superuser', 'in', 'range' => array(0, 1)),

        //length验证器
        //array('password','length','min'=>'6','max'=>'16','message'=>'{attribute}长度必须在{min}到{max}之间'),

        //类型验证 integer,float,string,array,date,time,datetime
        //array('created', 'type', 'datetime'),

        //日期格式验证
        //array('created', 'date', 'format'=>'yyyy/MM/dd/ HH:mm:ss'),

        //文件验证
        //array('filename', 'file', 'allowEmpty'=>true, 'types'=>'zip, rar, xls, pdf, ppt'),
    }

}