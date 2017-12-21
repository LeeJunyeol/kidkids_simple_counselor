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
}

.nav > .nav-header {
    text-align: center;
    padding: 5px;
    background: white;
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

.list-heading {
    margin-bottom: 10px;
}

.form-content {
    width: 100%;
    display: flex;
    margin-top: 10px;
    margin-bottom: 20px;
}

</style>
    <header style="width: 2030px">
        <h1 class="text-center">관리자 페이지</h1>
    </header>
    <div id="main-wrapper" style="display:flex; overflow-x: scroll; width: 2030px;">
    <div class="nav">
        <div class="nav-header"><h3 class="list-heading">관리 메뉴</h3></div>
        <div id="menu" class="list-group">
            <a href="#" class="list-group-item">질문 관리</a>
            <a href="#" class="list-group-item">답변 관리</a>
            <a href="#" class="list-group-item">회원 통계 및 등급 관리</a>
            <a href="#" class="list-group-item">카테고리 관리</a>
        </div>
    </div>

    <div class="main panel panel-default" style="border: 1px solid #ddd;">
        <!-- Default panel contents -->
        <div id="useradmin" class="hide">
        <script type="text/handlebars-template" id="user-admin-template">
            <div class="panel-heading text-center" style="background-color: #fff; color: #333">
                <h2 style="margin-bottom: 30px;">회원 통계 및 등급 관리(전문가 기준: 채택률 60%, 점수 100점 이상)</h2>
            </div>
            <div class="panel-body">
            <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>등급</th>
                    <th>질문수</th>
                    <th>답변수</th>
                    <th>답변채택율</th>
                    <th>점수</th>
                    <th>등급관리</th>
                </tr>
            </thead>
            {{#each this}}
                <tr {{#if ok}}style="background-color: yellow;"{{else}}{{#if no}}style="background-color: pink;"{{/if}}{{/if}}
                data-user='{"user_id": "{{user_id}}","user_type": "{{user_type}}"}'>
                <td>{{user_id}}</td>
                <td>{{name}}</td>
                <td>{{user_type}}</td>
                <td>{{question_cnt}}</td>
                <td>{{answer_cnt}}</td>
                <td>{{selection_percentage}}</td>
                <td>{{myscore}}</td>
                <td>{{#if ok}}<button class="advance btn btn-info">전문가 임명!</button>{{else}}{{#if no}}<button class="demolition btn btn-warning">강등..</button>{{/if}}{{/if}}</td>
                </tr>
            {{/each}}
            </table>
            </div>
        </script>
        </div>
        <div id="wrapper">
        <div id="form" class="panel-heading text-center" style="border-bottom: 1px solid #ddd;">

        <script type="text/handlebars-template" id="question-input-template">
            <h2 style="margin-bottom: 30px;">질문 목록</h2>

            <form class="form-inline">
                <div style="width: 100%; display: flex; justify-content: space-between;">
                    <div class="form-group">
                        <label for="User ID">작성자 아이디</label>
                        <input type="text" class="form-control" name="userId" id="inputUserID" placeholder="User ID">
                    </div>
                    <div class="form-group">
                        <label for="제목">제목</label>
                        <input type="text" class="form-control" name="title" id="inputTitle" placeholder="질문입니다.">
                    </div>
                    <div class="form-group">
                        <label for="조회수">조회수</label>
                        <input type="number" class="form-control" name="view" id="inputView" placeholder="조회수">
                    </div>
                    <div class="form-group">
                        <label for="태그">태그</label>
                        <input type="text" class="form-control" name="tags" id="inputTags" placeholder="태그">
                    </div>
                    <div class="form-group">
                        <label for="채택 답변 ID">채택 답변 번호</label>
                        <input type="number" class="form-control" name="selectedAnswerId" id="inputSelectedAnswerId" placeholder="채택 답변">
                    </div>
                </div>
            </form>
            <div class="form-content">
                <label for="내용" style="width: 80px">내용</label>
                <textarea class="form-control" name="content" id="inputContent" placeholder="내용입니다."></textarea>
            </div>
            <button type="submit" class="btn btn-default add">추가</button>

        </script>
        <script type="text/handlebars-template" id="answer-input-template">
            <h2 style="margin-bottom: 30px;">답변 목록</h2>

            <form class="form-inline">
                <div style="width: 100%; display: flex; justify-content: space-between;">
                    <div class="form-group">
                        <label for="Question ID">질문 번호</label>
                        <input type="text" class="form-control" name="questionId" id="inputQuestionID" placeholder="Question ID">
                    </div>
                    <div class="form-group">
                        <label for="User ID">작성자</label>
                        <input type="text" class="form-control" name="userId" id="inputUserID" placeholder="User ID">
                    </div>
                    <div class="form-group">
                        <label for="제목">제목</label>
                        <input type="text" class="form-control" name="title" id="inputTitle" placeholder="질문입니다.">
                    </div>
                    <div class="form-group">
                        <label for="채택여부">채택</label>
                        <input type="text" class="form-control" name="selection" id="inputSelection" placeholder="채택">
                    </div>
                </div>
            </form>
            <div class="form-content">
                <label for="내용" style="width: 80px">내용</label>
                <textarea class="form-control" name="content" id="inputContent" placeholder="내용입니다."></textarea>
            </div>
            <button type="submit" class="btn btn-default add">추가</button>
    </script>

        </div>

        <!-- Table -->
        <table class="table table-hover">
            <thead>
            <script type="text/handlebars-template" id="question-header-template">
            <tr>
                <th class="text-center">질문 번호</th>
                <th class="text-center">작성자 아이디</th>
                <th class="text-center">제목</th>
                <th class="text-center content">내용</th>
                <th class="text-center">조회수</th>
                <th class="text-center">태그</th>
                <th class="text-center selected_answer_id">채택 답변 번호</th>
                <th class="text-center">등록일</th>
                <th class="text-center">수정일</th>
                <!-- <th class="text-center">수정</th> -->
                <th class="text-center">삭제</th>
            </tr>
            </script>
            <script type="text/handlebars-template" id="answer-header-template">
            <tr>
                <th class="text-center">답변 번호</th>
                <th class="text-center">질문 번호</th>
                <th class="text-center">작성자 아이디</th>
                <th class="text-center">제목</th>
                <th class="text-center content">내용</th>
                <th class="text-center">채택 여부</th>
                <th class="text-center">등록일</th>
                <th class="text-center">수정일</th>
                <!-- <th class="text-center">수정</th> -->
                <th class="text-center">삭제</th>
            </tr>
            </script>
            <script type="text/handlebars-template" id="category-header-template">
            <!-- <tr>
                <th class="text-center">question_id</th>
                <th class="text-center">user_id</th>
                <th class="text-center">title</th>
                <th class="text-center content">content</th>
                <th class="text-center">view</th>
                <th class="text-center">create_date</th>
                <th class="text-center">modify_date</th>
                <th class="text-center">tags</th>
                <th class="text-center selected_answer_id">selected_answer_id</th>
                <th class="text-center">수정</th>
                <th class="text-center">삭제</th>
            </tr> -->
            </script> 
            </thead>
            <tbody id="table-main-body">
            <script type="text/handlebars-template" id="question-template">
            {{#each this}}
            <tr data-question-id={{question_id}} data-obj='{"questionId": "{{question_id}}","userId": "{{user_id}}","title": "{{title}}","content": "","view": "{{view}}","createDate": "{{create_date}}","modifyDate": "{{modify_date}}","tags": "{{tags}}","selectedAnswerId": "{{selected_answer_id}}"}'>
                <td class="text-center">{{question_id}}</td>
                <td class="text-center">{{user_id}}</td>
                <td class="text-center">{{title}}</td>
                <td class="content">{{content}}</td>
                <td class="text-center">{{view}}</td>
                <td class="text-center">{{tags}}</td>
                <td class="text-center" selected_answer_id>{{selected_answer_id}}</td>
                <td class="text-center">{{create_date}}</td>
                <td class="text-center">{{modify_date}}</td>
                <!-- <td class="text-center"><button class="update">수정</button></td> -->
                <td class="text-center"><button class="btn btn-danger delete">삭제</button></td>
            </tr>
            {{/each}}
            </script>
            <script type="text/handlebars-template" id="answer-template">
            {{#each this}}
            <tr data-answer-id={{answer_id}} data-obj='{"answerId": "{{answer_id}}", "questionId": "{{question_id}}","userId": "{{user_id}}","title": "{{title}}","content": "","selection": "{{selection}}","createDate": "{{create_date}}","modifyDate": "{{modify_date}}"}'>
                <td class="text-center">{{answer_id}}</th>
                <td class="text-center">{{question_id}}</th>
                <td class="text-center">{{user_id}}</th>
                <td class="text-center">{{title}}</th>
                <td class="content">{{content}}</th>
                <td class="text-center">{{selection}}</th>
                <td class="text-center">{{create_date}}</th>
                <td class="text-center">{{modify_date}}</th>
                <!-- <td class="text-center"><button class="update">수정</button></td> -->
                <td class="text-center"><button class="btn btn-danger delete">삭제</button></td>
            </tr>
            {{/each}}
            </script>

            </tbody>
        </table>
        </div>

        <nav id="pageNav" aria-label="Page navigation">
            <ul class="pagination">
            <script type="text/handlebars-template" id="pagination-template">
                <li class="previous">
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                {{#each this}}
                <li class="pageNum" data-num={{this}}>
                    <a href="#">{{this}}</a>
                </li>
                {{/each}}
                <li class="next">
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                </script>
            </ul>
        </nav>
    </div>
</div>

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
<script src="index.js"></script>

</body>

</html>