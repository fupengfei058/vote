<link rel="stylesheet" href="/css/wheel.css">
<link rel="stylesheet" href="/css/home.css">
<?php $contestant_json = json_encode($contestant); ?>
<div class="main">
    <div class="wrap clear">
        <div class="title clear">
            <a href="" class="active">选手榜</a>
        </div>
            <table class="top_rank">
                <tr>
                    <th>排名</th>
                    <th>编号</th>
                    <th>姓名</th>
                    <th>票数</th>
                </tr>
                <?php foreach ($contestant as $k => $v): ?>
                    <tr class="p_info">
                        <td class="p_rank"><?=$k+1?></td>
                        <td class="p_no"><?=$v['sortNum']?></td>
                        <td class="p_name"><?=$v['contestantName']?></td>
                        <td class="p_number"><?=$v['voteCount']?></td>
                    </tr>
                <?php endforeach ?>
            </table>
            <div class="img clear">
                <div class="fl"></div>
                <div class="ri"></div>
                <div class="tips"></div>
            </div>
    </div>
</div>
<div class="bg_mask">
    <div class="main1">
        <div class="bigwheel">
            <div class="wheel"></div>
            <div class="needle"></div>
        </div>
    </div>
</div>
<script>
    $(".f1-1-1").each(function(){
        this.style.height=this.offsetHeight+"px";
    });
    var oTip=$(".tips").eq(0);
    var l_div=$(".fl").get(0);
    var r_div=$(".ri").get(0);
    //投票按钮
    var oEle=null;
    $(".main").on('click', '#put_vote_btn', function(){
        oEle = this;
        $(this).val('投票中').addClass('voted').attr("disabled",true);
        var obj = $(this).closest('.f1-1-footer').find('.f1-1-footer-name-ps');
        var val = Number(obj.text());
        var obj2 = $("#count_record");
        var val2 = Number(obj2.text());
        var ts = this;
        $.ajax({
            url:'index.php?r=site/vote',
            data:{contestantId : $(this).data('id')},
            type:'post',
            dataType:'json',
            success:function(data) {
                if(data.code == -1){
                    alert(data.message);
                    $(ts).removeAttr("disabled").removeClass('voted').val('投票');
                }else if(data.code == 1000) {
                    alert(data.message);
                    $(ts).removeAttr("disabled").removeClass('voted').val('投票');
                    obj.text(++val);
                    obj2.text(++val2);
                }
            },
            error:function(res) {
                alert(JSON.stringify(res));
                $(ts).removeAttr("disabled").removeClass('voted').val('投票');
                alert("网络异常");
            }
        });
    });
    //瀑布流
    function fill(no,src,name,num,sort){
        var oDiv=document.createElement("div");
        oDiv.className="f1-1";
        var str='<div class="f1-1-1"><img src="'+src+'"><span class="f1-1-num">'+sort+'号</span><span class="f1-1-num-1"></span></div><div class="f1-1-footer"><div class="f1-1-footer-l"><p class="f1-1-footer-name">'+name+'</p><span class="f1-1-footer-name-ps">'+num+'</span>票</div><div class="f1-1-footer-r"><a><input id="put_vote_btn" data-id="'+no+'" type="button" value="投票"></a></div></div>';
        oDiv.innerHTML=str;
        eleArr.push(oDiv);
        (function(div,src_){
            var img=new Image();
            img.src=src_;
            img.onload=function(){
                div.getElementsByTagName("img")[0].src=this.src;
                index++;
                if(index==t_num){
                    addEle();
                }
                img=null;
            }
            img.onerror=function(){
                div.getElementsByTagName("img")[0].src="/images/default.jpg";
                index++;
                if(index==t_num){
                    addEle();
                }
                this.onerror=null;
                img=null;
            }
        })(oDiv,src);
    }
    var t_num=0;
    var index=0;
    var eleArr=[];
    function addEle(){
        for(var i=0;i<eleArr.length;i++)
            if(l_div.offsetHeight<=r_div.offsetHeight){
                l_div.appendChild(eleArr[i]);
            }
            else{
                r_div.appendChild(eleArr[i]);
            }
    }

    function loading(arr){
        oTip.fadeOut('fast');
        if(arr.length){
            t_num=arr.length;
            l_div.innerHTML="";
            r_div.innerHTML="";
            for (var i = 0; i < arr.length; i++) {
                fill(arr[i].contestantId,arr[i].pic,arr[i].contestantName,arr[i].voteCount,arr[i].sortNum);
            }
        }
        else{
            oTip.fadeOut('fast');
            oTip.innerHTML="没有相关数据！";
        }
    }
    var arr=<?php if (isset($contestant_json)) echo $contestant_json; else echo 0;?>;
    if (arr != 0) loading(arr);
</script>
