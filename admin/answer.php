<?php
session_start();
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$publicUrl = preg_replace('/admin\/.+\.php/','public/',$url, 1);
define('_URL',$publicUrl);
define('_CSS',_URL.'css');
define('_JS',_URL.'js');
define('_NODE',_URL.'node_modules');
define('_IMG',_URL.'images');
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
</head>
<body>
<style>
.form-group {
    display: flex;
}
label {
    width: 120px;
    text-align: center;
}
#form {
    padding: 50px;
}
</style>

<div id="form" class="panel-heading text-center">

</div>
<script type="text/handlebars-template" id="answer-view-template">
    <h2 style="margin-bottom: 30px;">답변 목록</h2>
    <button onclick="window.location.href='/admin'">뒤로가기</button>
    <form class="form">
        <div class="form-group">
            <label for="Answer ID">답변 번호</label>
            <input type="text" class="form-control" name="answerId" id="inputAnswerID" placeholder="Answer ID" value={{answer_id}}>
        </div>
        <div class="form-group">
            <label for="User ID">유저 아이디</label>
            <input type="text" class="form-control" name="userId" id="inputUserID" placeholder="User ID" value={{user_id}}>
        </div>
        <div class="form-group" style="width: 100%;">
            <label for="내용">Content</label>
            <textarea style="width: 100%; height: 350px;">{{content}}</textarea>
        </div>
        <div class="form-group">
            <label for="채택 여부">채택 여부</label>
            <input type="number" class="form-control" name="selection" id="inputSelection" placeholder="채택 여부" value={{selection}}>
        </div>
        <div class="form-group">
            <label for="등록일">등록일</label>
            <input type="text" class="form-control" name="createDate" id="inputCreateDate" placeholder="등록일" value={{create_date}}>
        </div>
        <div class="form-group">
            <label for="수정일">수정일</label>
            <input type="text" class="form-control" name="modifyDate" id="inputModifyDate" placeholder="수정일" value={{modify_date}}>
        </div>
        <button type="submit" class="btn btn-default delete">삭제</button>
    </form>
</script>
<style>
footer {
    background: #2A2730;
    width: 2030px;
    padding-top: 60px;
    padding-bottom: 60px;
    padding-right: 100px;
    color: white;
}
footer>.container {
    width: 100%;
    text-align: right;
}
</style>
<footer>
    <div class="container">
        <p>Designed and built with all the love in the world by @mdo and @fat. Maintained by the core team with the help of our contributors.</p>
        <p>EK KIDKIDS 2017</p>
    </div>
</footer>
<script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
<script src="<?php echo _JS ?>/util.js"></script>
<script src="/admin/answer.view.js"></script>

</body>

</html>