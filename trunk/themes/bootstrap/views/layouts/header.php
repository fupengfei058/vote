<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, height=device-height, minimum-scale=1.0,maximum-scale=1, user-scalable=0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <link rel="stylesheet" href="/css/index.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
    <div class="container">
    <header class="header">
        <div class="header_wrapper">
        </div>
        <div class="header_num">
            <ul>
                <li>
                    <p>已报名</p>
                    <strong><?= $this->contestantNumbers?></strong>
                </li>
                <li>
                    <p>投票数</p>
                    <strong id="count_record"><?= $this->item['totalVote']?></strong>
                </li>
            </ul>
        </div>
    </header>
