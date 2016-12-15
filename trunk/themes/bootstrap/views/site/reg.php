<link rel="stylesheet" href="/css/reg.css">
<div class="main">
    <div class="wrap clear">
        <h2 class="title">报名啦！</h2>
        <form action="" class="info_act">
            <div class="clear">
                <label for="">您的姓名:</label><input type="text" name="name" placeholder="请输入姓名">
            </div>
            <div class="clear">
                <label for="">联系电话:</label><input type="text" name="mobile" placeholder="请输入您的真实手机号码">
            </div>
            <div class="clear">
                <label for="">上传照片:<br><span>(1-5张照片)</span></label>
                <div class="u_img_area">
                    <input type="button" value="" id="upload">
                </div>
            </div>
            <div class="clear">
                <label for="">个性描述:<br/><span>(255字以内)</span></label>
                <textarea id="desc" placeholder="请输入描述" maxlength="255" cols="60" rows="5"></textarea>
            </div>
            <div class="confirm clear">
                <input type="button" value="确认报名" id="confirm_btn">
            </div>
        </form>
    </div>
</div>

<script>

    $.ajax({
        url:'/api/home/check_time',// 跳转到 action
        data:{vote_id : <?=isset($_SESSION['vote_id'])?$_SESSION['vote_id']:'' ?>},
        type:'post',
        dataType:'json',
        async:false,
        success:function(data) {
            if(data.state == 0 ){
                alert(data.msg);
                window.location.href="/home";
            }
        },
        error : function() {
            alert("异常！");
            window.location.href="/home";
        }
    });

    $.ajax({
        url:'/api/registration/check_is_open',// 跳转到 action
        data:{time : <?=time()?>},
        type:'post',
        dataType:'json',
        success:function(data) {
            if(data.state == 99){
                alert(data.msg);
                $(".overflow").fadeIn("fast");
            }
        },
        error : function(res) {
            alert(res.responseText);
            alert("异常！请刷新页面重试！");
        }
    });


    var wx_media_arr = [];
    var max=5;
    var now=0;
    //增加图片方法
    function addPics(src,id){
        var oDiv=document.createElement("div");
        oDiv.className="imgwrap";
        oDiv.id_=id;
        oDiv.innerHTML='<img src="'+src+'"><div class="close2">&times;</div>';
        $(oDiv).insertBefore("#upload");
        now++;
    }

    //微信图片上传
    $(".u_img_area").on('click', '#upload', function(){
        if(now>=max) {alert("最多只可上传五张图片"); return;}
        wx.chooseImage({
            count: 1, // 选择图片上限
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {//选择图片成功
                var localIds = res.localIds;
                wx.uploadImage({
                    localId: localIds[0],
                    isShowProgressTips: 1,
                    success: function (re) {//上传微信服务器成功
                        addPics(localIds[0],re.serverId);
                        wx_media_arr.push(re.serverId);// 返回图片的服务端ID
                    }
                });
            },
            fail:function(re){//chooseImage调用失败
                alert("系统繁忙！请稍候再试！");
                window.location.href="/home/index";
            }
        });
    });

    //删除图片方法
    function delPics(id_){
        for (var i = wx_media_arr.length - 1; i >= 0; i--) {
            if(wx_media_arr[i]==id_){
                wx_media_arr.splice(i,1);
                now--;
                break;
            }
            alert(i);
        };
    }
    //删除图片按钮
    $(".u_img_area").on("click",".close2",function(){
        var id_=$(this).parent().get(0).id_;
        delPics(id_);
        $(this).parent().remove();
    });

    //提交
    $(".main").on('click', '#confirm_btn', function() {
        var name = $("input[name=name]").val();
        var mobile = $("input[name=mobile]").val();
        var desc = $("#desc").val();
        if (name == '' || mobile == '' || desc == '') {//内容非空
            alert("请填写全部项目！");
            return false;
        };
        if (wx_media_arr.length == 0) {
            alert("请至少上传1张图片！");
            return false;
        };
        $("#confirm_btn").val("提交中...").addClass("disabled");

        $.ajax( {
            url:'/api/registration/reg',// 跳转到 action
            data:{
                name : name,
                mobile : mobile,
                desc : desc,
                wx_media_arr : JSON.stringify(wx_media_arr)
            },
            type:'post',
            dataType:'json',
            success:function(data) {
                alert(data.msg);
                if(data.state == 1 ){
                    window.location.href="/home";
                }else if (data.state == 99 ) {
                    $(".overflow").fadeIn("fast");
                }
                else{
                    window.location.reload();
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                //alert(XMLHttpRequest.responseText);
                alert("异常错误！请重试！");
            }
        });
    });

</script>