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
                        <textarea disabled>{{content}}</textarea>
                        <div class="question footer-group">
                            <div class="btn-group">
                                <button class="btn btn-default reply">답글달기</button>
                                <button class="btn btn-default view-opinions">댓글{{opinion_cnt}}</button>
                            </div>
                            <ul class="tags"> 태그:  
							{{#each tags}}
							<li class="tags">
								<span class="label label-info">{{this}}</span>
							</li>
							{{/each}}
							</ul>
                        </div>
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
                        <div class="reply-card container" data-id={{answer_id}} data-score={{votesum}}>
                            <div class="reply-title-group">
                                <div class="page-header">
                                    <span class="label label-success special">{{label}}</span>
                                    <h3 class="reply title">
                                        {{title}}
                                        <small>by {{author}}</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="reply-content-group">
                                <textarea style="height: {{height}}px" disabled>{{content}}</textarea>
                            </div>
                            <div class="reply-footer-group" data-id={{answer_id}}>
                                <div class="btn-group">
                                    <button class="btn btn-default view-opinions">댓글{{opinion_cnt}}</button>
                                </div>

                                <div class="vote-group" {{#if myvote}}data-value={{myvote}}{{/if}}>
                                    <div class="score">
                                        <h2 class="votesum"><span style="font-size: 20px;">추천도: </span><span class="score">{{votesum}}</span></h2>
                                    </div>
                                    <div class="sub-vote-group">
                                        <a class="vote up btn btn-default" href="#" role="button">추천
                                            <img src="http://localhost/ksc/public/images/up.png" />
                                        </a>
                                        <a class="vote down btn btn-default" href="#" role="button">
                                            <img src="http://localhost/ksc/public/images/down.png" />비추천
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{/each}}
                        </script>
                        <script type="text/handlebars-template" id="opinion-template">
                        <div class="opinion-list" style="margin-top: 10px;">
                            <div>
                                <div>댓글을 남겨주세요.</div>
                                <form class="{{#if question_id}}question opinion form{{else}}answer opinion form{{/if}}" action="#" method="post">
                                    {{#if question_id}}
                                    <input type="text" name="question_id" value={{question_id}} />
                                    {{/if}}
                                    {{#if answer_id}}
                                    <input type="text" name="answer_id" value={{answer_id}} />
                                    {{/if}}
                                    <input type="text" name="content" />
                                    <button type="submit">등록</button>
                                </form>
                            </div>
                            
                            <ul class="opinion-list{{#if opinions}}{{else}} hide{{/if}}" style="list-style: none; -webkit-padding-start: 0; border: 2px solid;">
                            {{#each opinions}}
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
                            </ul>
                            <div>
                                <a href="#" class="close opinions">댓글 접기</a>
                            </div>
                        </div>
                        </script>
                        <script type="text/handlebars-template" id="opinion-item-template">
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
	<script src="<?php echo _JS ?>/util.js"></script>
	<script src="<?php echo _JS ?>/common.js"></script>
	<script src="<?php echo _JS ?>/view-question.js"></script>
</body>

</html>