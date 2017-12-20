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
    <style>
    .selected { 
        border-color: #fff;
        background-color: #68FF9C;
        color: white;
    }
    .select-btn:not(.selected):focus { 
        outline: none;
    }
    .select-btn.selected:focus { 
        outline: none;
        border-color: #fff;
        background-color: #68FF9C;
        color: white;
    }
    .selected-answer {
        border: blue solid !important;
    }
    
    </style>
</head>

<body>
<?php
require_once "header.php";
?>
            <!-- 메인 -->
            <article class="view">
                <div class="wrapper">
                    <div id="question-container" class="question container hide" style="position: relative">
                    <script type="text/handlebars-template" id="question-template">
                        <div class="header-group" data-id={{user_id}} style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 20px;">
                            <div>
                                <h3 class="title">Q. {{title}}<small>by {{user_id}}</small></h3>
                                작성일: {{create_date}}, 수정일: {{modify_date}}
                            </div>
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
                        <div class="panel panel-default" style="display: flex; justify-content: space-between; padding: 10px 10px 10px 5px">
                            <div class="panel-body">
                            님의 지식을 나누어 주세요! 감사합니다 ^^* 
                            </div>
                            <button class="btn btn-primary reply btn-lg">A 답변하기</button>
                        </div>
                    </script>

                    </div>
                    <div id="write-box" class="container" style="display: none">
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
                        <div class="reply-card container" data-id={{answer_id}} data-score={{votesum}} style="position: relative" data-selection={{selection}}>
                            <button type="button" class="select-btn btn btn-default btn-lg hide" style="position: relative; top: 15px; left: 5px; float: right; font-size: 23px; border-radius:45.5%; padding: 10px; margin-left: 20px;">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                            <div class="edit-btn-group btn-group" style="float: right; margin-top: 20px;">
                                <button type="button" class="btn btn-default edit" aria-label="Left Align" style="float: none; position: static;">
                                    <span class="edit glyphicon glyphicon glyphicon-pencil" aria-hidden="true">수정</span>
                                </button>
                                <button type="button" class="btn btn-default delete" aria-label="Left Align" style="float: none; position: static; margin-left: -5px;">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true">삭제</span>
                                </button>
                            </div>
                            <div class="reply-title-group">
                                <div class="page-header">
                                    <span class="label label-success user-type">{{label}}</span>
                                    <div style="display: flex; align-items: center;">
                                        <div class="img-div hide" style="width: 100px; height: 120px; margin-top: 20px; margin-right: 20px;">
                                            <img style="width: 100%; height: 100%" src="/ksc/user_images/{{user_pic}}"/>
                                        </div>
                                        <h3 class="reply title">
                                            <span><span class="answer-author">{{author}}</span>님의 답변입니다.</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="reply-content-group">
                                <textarea style="height: {{height}}px" disabled>{{content}}</textarea>
                            </div>
                            <div class="reply-footer-group" data-id={{answer_id}}>
                                <div class="btn-group">
                                    <button class="btn btn-default view-opinions">댓글{{#if opinion_cnt}}{{opinion_cnt}}{{else}}0{{/if}}</button>
                                </div>

                                <div class="vote-group" {{#if myvote}}data-value={{myvote}}{{/if}}>
                                    <div class="sub-vote-group">
                                        <a class="vote up btn btn-default" href="#" role="button">추천
                                            <img src="/ksc/public/images/up.png" /><span>{{#if plus_vote_cnt}}{{plus_vote_cnt}}{{else}}0{{/if}}</span>
                                        </a>
                                        <a class="vote down btn btn-default" href="#" role="button">
                                            <img src="/ksc/public/images/down.png" />비추천<span>{{#if minus_vote_cnt}}{{minus_vote_cnt}}{{else}}0{{/if}}</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{/each}}
                        </script>
                        <script type="text/handlebars-template" id="opinion-template">
                        <div class="opinion-list hide" style="margin-top: 10px;">
                            <div>
                                <div>댓글을 남겨주세요.</div>
                                <form class="{{#if question_id}}question opinion form{{else}}answer opinion form{{/if}}" action="#" method="post">
                                    {{#if question_id}}
                                    <input type="text" name="id" value={{question_id}} class="hide" />
                                    {{else}}
                                    <input type="text" name="id" value={{answer_id}} class="hide" />
                                    {{/if}}
                                    <input type="text" name="content" />
                                    <button type="submit">등록</button>
                                </form>
                            </div>
                            
                            <ul class="opinion-list" style="list-style: none; -webkit-padding-start: 0; border: 2px solid;">
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
                                            <span cl
                                            ass="glyphicon glyphicon-remove" aria-hidden="true"></span>
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
                        <script type="text/handlebars-template" id="opinion-answer-template">
                        <div class="opinion-list hide" style="margin-top: 10px;">
                            <div>
                                <div>댓글을 남겨주세요.</div>
                                <form class="answer opinion form" action="#" method="post">
                                    <input type="text" name="content" />
                                    <button type="submit">등록</button>
                                </form>
                            </div>
                            
                            <ul class="opinion-list" style="list-style: none; -webkit-padding-start: 0; border: 2px solid;">
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