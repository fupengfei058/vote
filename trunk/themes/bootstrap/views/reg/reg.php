<link rel="stylesheet" href="/css/reg.css">
<div class="main">
    <div class="wrap clear info_act">
        <h2 class="title">报名啦！</h2>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'reg-form',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            )); ?>
            <div class="clear">
                <label>您的姓名:</label><?php echo $form->textField($model,'contestantName',array('placeholder'=>'请输入姓名')); ?>
            </div>
            <div class="clear">
                <label>联系电话:</label><?php echo $form->textField($model,'mobile',array('placeholder'=>'请输入联系电话')); ?>
            </div>
            <div class="clear">
                <label>上传照片:<br><span>(1张照片)</span></label>
                <div class="u_img_area">
                    <?php echo CHtml::activeFileField($model,'pic'); ?>
                </div>
            </div>
            <div class="clear">
                <label>个性描述:<br/><span>(255字以内)</span></label>
                <?php echo $form->textArea($model,'desc',array('placeholder'=>'请输入描述','maxlength'=>"255",'cols'=>"60","rows"=>"5")); ?>
            </div>
            <div class="confirm clear">
                <?php echo CHtml::submitButton('确认报名',array('id'=>'confirm_btn')); ?>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    $.ajax({
        url:'./index.php?r=reg/checkreg',
        data:{},
        type:'post',
        dataType:'json',
        async:false,
        success:function (data) {
            if (data.code == -1) {
                alert(data.message);
                window.location.href="./index.php?site/index";
            }
        }
    });
</script>
