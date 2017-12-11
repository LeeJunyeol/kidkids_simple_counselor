<?php
session_start();
if(!isset($_SESSION["user"])){
	header("location: home");
}
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
	<link href="<?php echo _CSS?>/write-question.css" rel="stylesheet">
</head>

<body>
<?php
require_once "header.php";
?>
	<!-- 메인 -->
	<article class="write">
		<div class="wrapper">
			<div class="container">
				<div class="write category">
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdown-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							<span class="top unclicked">카테고리</span>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li>
								<a href="#">육아/건강</a>
							</li>
							<li>
								<a href="#">교육/놀이</a>
							</li>
							<li>
								<a href="#">안전</a>
							</li>
							<li>
								<a href="#">음식</a>
							</li>
							<li>
								<a href="#">기타</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="write header">
					<textarea placeholder="제목"></textarea>
				</div>
				<div class="write content">
					<textarea placeholder="내용을 입력하세요."></textarea>
				</div>
				<div class="write tags">
					<div>
						<span>
							<strong>태 그: </strong>
						</span>
					</div>
					<div class="input-tag-area" style="display:flex;">
						<ul class="tags" style="list-style: none; -webkit-padding-start: 0px; display:flex;">
							<script type="text/handlebars-template" id="tag-template">
								<li class="tags">
									<span class="label label-default" style="margin-left: 2px;">{{this}}</span>
								</li>
							</script>
						</ul>
						<input type="text" placeholder="입력(최대 5개)" style="border: none;">
					</div>
				</div>
				<div class="submit">
					<button id="btn-post-question" class="btn btn-default" type="submit">등록</button>
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
	<script src="<?php echo _JS ?>/common.js"></script>
	<script src="<?php echo _JS ?>/write-question.js"></script>
	<script>
		$(document).ready(function () {
			$('div.write').on('keyup', 'textarea', function (e) {
				$(this).css('height', 'auto');
				$(this).height(this.scrollHeight);
			});
		});
	</script>
</body>

</html>