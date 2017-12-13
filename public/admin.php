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
</head>
<body>
<header>
	<h1 class="text-center">관리자 페이지</h1>
</header>

<div class="panel panel-default">
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
				<th class="text-center">content</th>
				<th class="text-center">view</th>
				<th class="text-center">create_date</th>
				<th class="text-center">modify_date</th>
				<th class="text-center">수정</th>
				<th class="text-center">삭제</th>
			</tr>
		</thead>
		<tbody>
        <script type="text/handlebars-template" id="admin-item-template">
        <tr>
            <td class="text-center">{{question_id}}</td>
            <td class="text-center">{{user_id}}</td>
            <td class="text-center">{{category}}</td>
            <td class="text-center">{{title}}</td>
            <td class="text-center">{{content}}</td>
            <td class="text-center">{{view}}</td>
            <td class="text-center">{{create_date}}</td>
            <td class="text-center">{{modify_date}}</td>
            <td class="text-center">수정</td>
            <td class="text-center">삭제</td>
        </tr>
        </script>
		</tbody>
	</table>
</div>
<div class="footer-clean">
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4 item">
                <h3>Services</h3>
                <ul>
                    <li><a href="#">Web design</a></li>
                    <li><a href="#">Development</a></li>
                    <li><a href="#">Hosting</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-4 item">
                <h3>About</h3>
                <ul>
                    <li><a href="#">Company</a></li>
                    <li><a href="#">Team</a></li>
                    <li><a href="#">Legacy</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-4 item">
                <h3>Careers</h3>
                <ul>
                    <li><a href="#">Job openings</a></li>
                    <li><a href="#">Employee success</a></li>
                    <li><a href="#">Benefits</a></li>
                </ul>
            </div>
            <div class="col-md-3 item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a>
                <p class="copyright">Company Name © 2016</p>
            </div>
        </div>
    </div>
</footer>
</div>
<script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
<script src="<?php echo _JS ?>/admin.js"></script>
<?php
if(isset($jsPaths)){
    foreach ($jsPaths as $path){
        echo "<script src=$path></script>";        
    }
}
?>
</body>

</html>