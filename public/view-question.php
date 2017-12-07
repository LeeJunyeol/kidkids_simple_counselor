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
            <article class="center-block">
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
                        <div class="reply-card container">
                            <div class="reply-title-group">
                                <div class="page-header">
                                    <span class="label label-success special">전문가</span>

                                    <h3 class="reply title">
                                        <span class="label label-default">7</span> 답변입니다.
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
                                    이렇게 해보세요.
                                </p>
                            </div>
                            <div class="reply-footer-group">
                                <button class="btn">의견 남기기</button>
                            </div>
                            <div class="opinion-list" style="margin-top: 10px;">
                                <ul style="list-style: none; -webkit-padding-start: 0; border: 2px solid;">
                                    <li style="border-bottom: 1px solid; padding: 10px 10px 5px 5px;">
                                        <div class="opinion-card-header" style="display: flex; justify-content: space-between;">
                                            <div style="width: 100%">
                                                <p class="opinion">
                                                    의견입니다.
                                                </p>
                                            </div>
                                            <div class="edit-btn-group" style="float: right; width: 50px;">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="opinion-card-footer">
                                            <span class="author">
                                                작성자
                                            </span>
                                            <span>
                                                작성일자
                                            </span>
                                        </div>
                                    </li>
                                    <li style="border-bottom: 1px solid; padding: 10px 10px 5px 5px;">
                                        <div class="opinion-card-header" style="display: flex; justify-content: space-between;">
                                            <div style="width: 100%">
                                                <p class="opinion">
                                                    의견입니다.
                                                </p>
                                            </div>
                                            <div class="edit-btn-group" style="float: right; width: 50px;">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="opinion-card-footer">
                                            <span class="author">
                                                작성자
                                            </span>
                                            <span>
                                                작성일자
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>

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
	<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
	<script src="<?php echo _JS ?>/view-question.js"></script>
	<script src="<?php echo _JS ?>/common.js"></script>
</body>

</html>