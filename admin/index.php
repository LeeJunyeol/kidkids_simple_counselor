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

h1, h2, h3 {
    margin: 0;
}


#main-wrapper {
    height: 100%;
}
header {
    padding: 20px;
}

.main {
    width: 100%;
}

.nav {
    width: 15%;
    height: 100%;
    background: white;
}

.nav > .nav-header {
    background-color: yellow;
    text-align: center;
    padding: 5px;
}

.nav ul {
    list-style: none;
}

.nav li {
    padding: 5px;
}

.main.panel {
    margin-bottom: 0;
}

table .content {
    width: 470px;
}

</style>
<header>
	<h1 class="text-center">관리자 페이지</h1>
</header>
<div id="main-wrapper" style="display:flex;">
    <div class="nav">
        <div class="nav-header"><h3>관리 메뉴</h3></div>
        <div>
            <ul id="menu">
                <li>질문 관리</li>
                <li>답변 관리</li>
                <li>카테고리 관리</li>
                <li>회원 관리</li>
            </ul>
        </div>
    </div>

    <div class="main panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">

            <h2 style="margin-bottom: 30px;">질문 목록</h2>

            <form class="form-inline" style="display: flex; justify-content: space-around;">
                <div class="form-group">
                    <label for="ID(문자열)">User ID</label>
                    <input type="text" class="form-control" id="inputUserID" placeholder="ID">
                </div>
                <div class="form-group">
                    <label for="카테고리">Category</label>
                    <input type="text" class="form-control" id="inputCategory" placeholder="육아">
                </div>
                <div class="form-group">
                    <label for="제목">Title</label>
                    <input type="text" class="form-control" id="inputTitle" placeholder="질문입니다.">
                </div>
                <div class="form-group">
                    <label for="내용">Content</label>
                    <input type="text" class="form-control" id="inputContent" placeholder="내용입니다.">
                </div>
                <div class="form-group">
                    <label for="조회수">View</label>
                    <input type="number" class="form-control" id="inputView" placeholder="조회수">
                </div>
                <button type="submit" class="btn btn-default add">추가</button>
            </form>

        </div>

        <!-- Table -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">question_id</th>
                    <th class="text-center">user_id</th>
                    <th class="text-center">category</th>
                    <th class="text-center">title</th>
                    <th class="text-center content">content</th>
                    <th class="text-center">view</th>
                    <th class="text-center">create_date</th>
                    <th class="text-center">modify_date</th>
                    <th class="text-center">tags</th>
                    <th class="text-center selected_answer_id">selected_answer_id</th>
                    <th class="text-center">수정</th>
                    <th class="text-center">삭제</th>
                </tr>
            </thead>
            <tbody>
            <script type="text/handlebars-template" id="question-template">
            {{#each this}}
            <tr>
                <td class="text-center">{{question_id}}</td>
                <td class="text-center">{{user_id}}</td>
                <td class="text-center">{{category}}</td>
                <td class="text-center">{{title}}</td>
                <td class="text-center content">{{content}}</td>
                <td class="text-center">{{view}}</td>
                <td class="text-center">{{create_date}}</td>
                <td class="text-center">{{modify_date}}</td>
                <td class="text-center">{{tags}}</td>
                <td class="text-center" selected_answer_id>{{selected_answer_id}}</td>
                <td class="text-center"><button class="update">수정</button></td>
                <td class="text-center"><button class="delete">삭제</button></td>
            </tr>
            {{/each}}
            </script>
            <script type="text/handlebars-template" id="answer-template">
            {{#each this}}
            <tr>
                <td class="text-center">{{question_id}}</td>
                <td class="text-center">{{user_id}}</td>
                <td class="text-center">{{category}}</td>
                <td class="text-center">{{title}}</td>
                <td class="text-center content">{{content}}</td>
                <td class="text-center">{{view}}</td>
                <td class="text-center">{{create_date}}</td>
                <td class="text-center">{{modify_date}}</td>
                <td class="text-center">{{tags}}</td>
                <td class="text-center" selected_answer_id>{{selected_answer_id}}</td>
                <td class="text-center"><button class="update">수정</button></td>
                <td class="text-center"><button class="delete">삭제</button></td>
            </tr>
            {{/each}}
            </script>

            </tbody>
        </table>
    </div>
</div>

<style>
footer {
    background: #2A2730;
    padding-top: 60px;
    padding-bottom: 60px;
    color: white;
}

footer>.container {
    width: 1100px;
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
<script src="index.js"></script>

</body>

</html>