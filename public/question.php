<?php
session_start();
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
            <article class="view">
                <div class="wrapper">
                    <div id="question-container" class="question container hide">
                    <script type="text/handlebars-template" id="question-template">
                        <div class="header-group" data-id={{user_id}} style="display: flex; align-items: baseline; justify-content: space-between;">
                            <h3>Q. {{title}}</h3>
                            <div class="btn-group not-visible">
                                <button type="button" class="btn btn-default edit" aria-label="Left Align" style="float: none; position: static;">
                                    <span class="edit glyphicon glyphicon glyphicon-pencil" aria-hidden="true">수정</span>
                                </button>
                                <button type="button" class="btn btn-default delete" aria-label="Left Align" style="float: none; position: static; margin-left: -5px;">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true">삭제</span>
                                </button>
                            </div>
                        </div>
                        <p>
                            {{content}}
                        </p>
                        <button class="btn btn-default reply">답글달기</button>
                        <button class="btn btn-default">의견 남기기</button>
                    </script>
                    </div>
                    <div id="write-box" class="container" style="display: none">
                        <div class="write header">
                            <textarea placeholder="제목"></textarea>
                        </div>
                        <div class="write content">
                            <textarea placeholder="내용을 입력하세요."></textarea>
                        </div>
                        <div class="submit">
        					<button id="btn-post-reply" class="btn btn-default" type="submit">등록</button>
		        		</div>
                    </div>
                    <div class="reply-box">
                        <script type="text/handlebars-template" id="answer-template">
                        {{#each this}}
                        <div class="reply-card container" data-id={{answer_id}}>
                            <div class="reply-title-group">
                                <div class="page-header">
                                    <span class="label label-success special">{{label}}</span>

                                    <h3 class="reply title">
                                        <span class="label label-default">{{vote_cnt}}</span> {{title}}
                                        <small>by {{user_id}}</small>
                                    </h3>
                                </div>

                                <div class="vote-group">
                                    <span class="vote up glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                    <span class="vote down glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="reply-content-group">
                                <p>
                                    {{content}}
                                </p>
                            </div>
                            <div class="reply-footer-group" data-id={{answer_id}}>
                                <button class="btn btn-default write-opinion">의견 남기기</button>
                                <button class="btn btn-default view-opinions">의견 보이기</button>
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
                    </div>
                </div>
            </article>
<?php
require_once "aside.php";
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