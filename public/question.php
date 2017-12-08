<?php

require_once "config.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>타이틀</title>
    <link href="<?php echo _NODE?>/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo _CSS?>/Footer-Clean.css" rel="stylesheet">
    <link href="<?php echo _CSS?>/common.css" rel="stylesheet">
    <link href="<?php echo _CSS?>/view-question.css" rel="stylesheet">
</head>

<body>
<?php
require_once "header.php";
?>
            <!-- 메인 -->
            <article class="view" data-id="<?php echo $_POST["question_id"]?>">
                <div class="wrapper">
                    <div class="question container">
                    <script type="text/handlebars-template" id="question-template">
                        <h3>Q. {{title}}.</h3>
                        <p>
                            {{content}}
                        </p>
                        <button class="btn">답글달기</button>
                        <button class="btn">의견 남기기</button>
                    </script>
                    </div>

                    <div class="reply-box">
                        <script type="text/handlebars-template" id="answer-template">
                        {{#each this}}
                        <div class="reply-card container">
                            <div class="reply-title-group">
                                <div class="page-header">
                                    <span class="label label-success special">{{label}}</span>

                                    <h3 class="reply title">
                                        <span class="label label-default">{{vote_cnt}}</span> {{title}}
                                        <small>by {{user_id}}</small>
                                    </h3>
                                </div>

                                <div class="vote-group">
                                    <span class="vote glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                    <span class="vote glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="reply-content-group">
                                <p>
                                    {{content}}
                                </p>
                            </div>
                            <div class="reply-footer-group" data-id={{answer_id}}>
                                <button class="btn write-opinion">의견 남기기</button>
                                <button class="btn view-opinions">의견 보이기</button>
                            </div>
                            <div class="opinion-list" style="margin-top: 10px;">
                                <ul class="opinion-list hide" style="list-style: none; -webkit-padding-start: 0; border: 2px solid;">
                                </ul>
                            </div>
                        </div>
                        {{/each}}
                        </script>
                        <script type="text/handlebars-template" id="opinion-template">
                        {{#each this}}
                        <li style="border-bottom: 1px solid; padding: 10px 10px 5px 5px;">
                            <div class="opinion-card-header" style="display: flex; justify-content: space-between;">
                                <div style="width: 100%">
                                    <p class="opinion">
                                        {{content}}
                                    </p>
                                </div>
                                <div class="edit-btn-group" style="float: right; width: 50px;">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="opinion-card-footer">
                                <span class="author">
                                    {{user_id}}
                                </span>
                                <span>
                                    {{modify_date}}
                                </span>
                            </div>
                        </li>
                        {{/each}}
                        </script>


                        <div class="reply-card container">
                            <div class="reply-title-group">
                                <div class="page-header">
                                    <span class="label label-success special">전문가</span>

                                    <h3 class="reply title">
                                        <span class="label label-default">3</span> 답변입니다.
                                        <small>by 이준열</small>
                                    </h3>
                                </div>

                                <div class="vote-group">
                                    <span class="vote glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                    <span class="vote glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="reply-content-group">
                                <p>
                                    저렇게 해보세요.
                                </p>
                            </div>
                            <div class="reply-footer-group">
                                <button class="btn">의견 남기기</button>
                            </div>
                            <div class="opinion-list">
                                <ul style="list-style: none;">
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
<?php
require_once "footer.php";
?>
    <script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
	<script src="<?php echo _NODE ?>/jquery.redirect/jquery.redirect.js"></script>
	<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
	<script src="<?php echo _JS ?>/common.js"></script>
	<script src="<?php echo _JS ?>/util.js"></script>
	<script src="<?php echo _JS ?>/view-question.js"></script>
</body>

</html>