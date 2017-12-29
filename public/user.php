<?php
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>키고상: 마이페이지</title>
    <link href="<?php echo _NODE?>/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo _CSS?>/common.css" rel="stylesheet">
	<link href="<?php echo _CSS?>/my.css" rel="stylesheet">
</head>

<body>
<?php
require_once "header.php";
?>
<article>
    <div id="top-container">
        <div id="profile-box">
            <div class="box" style="position: relative">
                <script type="text/handlebars-template" id="expert-template">
                <div style='position: absolute; top: -40px; left: -8px; width: 80px; margin: auto;'>
                    <img src='/public/images/giphy.gif' style='display: block; width: 33px; height: 33px; margin: auto;'>
                    <label class='my-label label label-info' style='display: block; padding: .3em .3em .3em; font-size: 130%;'>{{user_type}}</label>
                </div>
                </script>
                <script type="text/handlebars-template" id="user-template">
                <div class="my-image" style="width: 200px; height: 100%; margin-top: 6px;">
                    <img src="{{user_pic}}" style="width: 100%; height: 100%" />
                </div>
                <div class="my-info" style="width: 100%; position: relative;">
                    <div class="edit-btn-group btn-group hide" style="position: absoulte; left: 79%; top: 0;">
                        <button type="button" class="btn btn-default edit" aria-label="Left Align">
                            <span class="edit glyphicon glyphicon glyphicon-pencil" aria-hidden="true">수정</span>
                        </button>
                        <button type="button" class="btn btn-default delete" aria-label="Left Align" style="margin-left: -5px;">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true">회원 탈퇴</span>
                        </button>
                    </div>
                    <div class="profile-area">
                        <div>
                            <h2><span id="username">{{name}}</span></h2>
                        </div>
                        <div>
                            <label>이메일: </label>
                            <span id="useremail">{{email}}</span>
                        </div>
                    </div>
                    <div class="score-area">
                        <h3>레벨: <span id="{{userlevel}}">{{userlevel}}</span></h3>
                        <div class="progress">
                            <div id="progress" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{score}}"
                            aria-valuemin="0" aria-valuemax="500" style="width: {{scorePer}}%">
                            <span class="sr-only">10% Complete (success)</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
                </script>
            </div>
        </div>
        <div id="rank-box">
            <div class="box">
            <script type="text/handlebars-template" id="current-rank-template">
            <h3 class="text-center" style="margin-bottom: 10px";>현재 순위</h3>
            <table class="rank-table table table-striped" style="border-top: 2px solid #ddd;">
                <thead>
                    <tr>
                        <th class="rank-table-head rank">순위</th>
                        <th class="rank-table-head id">아이디</th>
                        <th class="rank-table-head score">점수</th>
                    </tr>
                </thead>
                <tbody id="rank-body">
                    {{#each this}}
                    <tr>
                        <td class="rank-table-item rank">{{rank}}</td>
                        <td class="rank-table-item id"><a href="/user/{{user_id}}">{{user_id}}</a></td>
                        <td class="rank-table-item score">{{score}}</td>
                    </tr>
                    {{/each}}
                </tbody>
            </table>

            </script>
        </div>
        </div>
    </div>
    <div id="second-container">
        <div>
            <div id="question-box" class="box">
                <h2>최근 질문</h2>
                <script type="text/handlebars-template" id="recent-question-template">
                <ul class="question wrap">
                    {{#each this}}
                    <li class="question list-group-item" data-id={{question_id}}>
                        <div class="list-header">
                            <h3><a href="{{link}}" class="list-head">{{title}}</a></h3>
                        </div>
                        <div class="list-main">
                            <p>{{content}}</p>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{create_date}}</span>
                        </div>
                    </li>
                    {{/each}}
                </ul>
                </script>
            </div>
        </div>
        <div>
            <div id="answer-box" class="box">
                <h2>최근 답변</h2>
                <script type="text/handlebars-template" id="recent-answer-template">
                <ul class="answer wrap">
                    {{#each this}}
                    <li class="answer list-group-item" data-id={{answer_id}}>
                        <div class="list-header">
                            <h3><a href="{{link}}" class="list-head">{{question_id}}번에 대한 답변입니다.</a></h3>
                        </div>
                        <div class="list-main">
                            <span>{{content}}</span>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{create_date}}</span>
                        </div>
                    </li>
                    {{/each}}
                </ul>
                </script>
            </div>
        </div>
    </div>

</article>
</div>

    
<?php
require_once "footer.php";
?>
    <script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
    <script src="<?php echo _NODE ?>/jquery.redirect/jquery.redirect.js"></script>
    <script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
    <script src="<?php echo _DISTJS ?>/user.js"></script>

</body>

</html>