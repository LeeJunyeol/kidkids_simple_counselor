<?php
require_once "config.php";
if(!isset($_SESSION["logged_in"])){
	echo "<script>alert(\"로그인이 필요한 서비스입니다.\");
	location.href=\"/ksc/login\"</script>";
}
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
					<label>카테고리를 선택 또는 검색해주세요.</label>
					<div id="search-category-form" class="input-group stylish-input-group">
					<span class="input-group-addon">
						<button id="click-category" type="submit" data-target="#modalForm">
							<span>카테고리 선택</span>
						</button>
					</span>
					<input type="text" class="form-control"  placeholder="Search" >
					<span class="input-group-addon">
						<button id="search-category" type="submit" data-target="#modalForm">
							<span class="glyphicon glyphicon-search"></span>
						</button>  
					</span>
				</div>
				<div class="selected-category hide">
				<h3></h3>
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
					<button id="btn-post-question" class="btn btn-default post" type="submit">등록</button>
				</div>
			</div>
		</div>
	</article>
<?php
require_once "aside.php";
require_once "footer.php";
?>
<style>
#ul-search-list input[readonly]{
	background-color: white;
}
</style>
<!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" onclick="modalHide()">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">카테고리를 선택해 주세요.</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
				<form id="search-category-list-form">
				<ul id="ul-search-list">
				<script type="text/handlebars-template" id="search-category-template">
				{{#each this}}
					<li>
					<div class="input-group">
						<span class="input-group-addon"><input type="radio" name="category-list" value={{category_id}} data-name={{category_name}} data-cid-set={{category_id_set}}></span>
						<input type="text" class="form-control" aria-label="..." value="{{category_string}}" readonly>
				    </div><!-- /input-group -->
					</li>
				{{/each}}
				</script>
				</ul>
				<ul id="ul-category-all-list">
				<script type="text/handlebars-template" id="category-all-list-template">
				{{#each this}}
					<li>
					<div class="input-group">
						<span class="input-group-addon"><input type="radio" name="category-list" value={{category_id}} data-name={{category_name}} data-cid-set={{category_id_set}}></span>
						<input type="text" class="form-control" aria-label="..." value="{{category_string}}" readonly>
				    </div><!-- /input-group -->
					</li>
				{{/each}}
				</script>
				</ul>

				</form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="modalHide()">닫기</button>
                <button type="button" class="btn btn-primary submitBtn">입력</button>
            </div>
        </div>
    </div>
</div>
	<script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
	<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
	<script src="<?php echo _JS ?>/util.js"></script>
	<script src="<?php echo _JS ?>/common.js"></script>
	<script src="<?php echo _JS ?>/write-question.js"></script>
	<script>
		$(document).ready(function () {
			$('div.write').on('keyup', 'textarea', function (e) {
				$(this).css('height', 'auto');
				$(this).height(this.scrollHeight);
			});
		});
		function modalHide(){
            $('#modalForm').modal('hide');
        }
	</script>
</body>

</html>