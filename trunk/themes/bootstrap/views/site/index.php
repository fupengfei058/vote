<head><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<style>
    .tbl{
        padding-left: 50px;
    }
    .vote_num{
        color: #1DC116;
    }
</style>
<div class="container">
    <table class="table">
        <tr>
            <td colspan="2" class="tbl"><p class="text-center">这是一个投票活动</p></td>
        </tr>
        <?php foreach($contestant as $v):?>
            <tr>
                <input type="hidden" value="<?= $v['contestantId']?>">
                <td><img width="150px" height="150px" src="<?= json_decode($v['picList'])[0]?>"></td>
                <td class="tbl">票数：<span class="vote_num"><?= $v['voteCount']?></span></td>
                <td class="tbl"><button type="button" class="btn btn-primary vote">投票</button></td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    $(".vote").click(function(){
        var contestantId = $(this).parent().parent().find('input').val();
        var vote_num = parseInt($(this).parent().parent().find(".vote_num").text());
        $.ajax({
            url:'index.php?r=site/vote',
            type:'post',
            dataType:'json',
            data:{'contestantId':contestantId},
            success:function(){
                $(this).parent().parent().find(".vote_num").text(vote_num+1)
            }
        });

    });
</script>