<?php
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>카테고리 검색</title>
	<link href="<?php echo _NODE?>/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo _CSS?>/common.css" rel="stylesheet">
	<style>
	article {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		padding: 0px 20px;
		background: #FAFBFC;
		box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
	}
	.box {
		width: 100%;
		max-width: 480px;
		margin: 10px;
	}

	.box>.head {
	}

	.box>.body {
		padding: 5px;
	}

	.list-item {
		margin: 5px;
	}

	
	</style>
</head>
<body>
<?php
require_once "header.php";
?>
	<article>
		<div class="search-result box panel panel-default">
			<div class="search-result head question panel-heading">
				<h1>질문 검색 결과</h1>
			</div>
			<div class="search-result body question panel-body">
			<script type="text/handlebars-template" id="question-result-template">
			{{#if this}}
			<ul>
			{{#each this}}
			<li class="list-item">
			<h3><a href="/ksc/question/{{question_id}}">{{title}}</a></h3>
			{{content}}
			</li>
			{{/each}}
			</ul>
			{{else}}
			<h2>검색 결과가 없습니다.</h2>
			{{/if}}
			</script>
			</div>
		</div>
		<div class="search-result box panel panel-default">
			<div class="search-result head answer panel-heading">
				<h1>답변 검색 결과</h1>
			</div>
			<div class="search-result body answer panel-body">
			<script type="text/handlebars-template" id="answer-result-template">
			{{#if this}}
			<ul>
			{{#each this}}
			<li class="list-item">
			<h3><a href="/ksc/question/{{question_id}}">{{question_id}}번 글 답변입니다.</a></h3>
			{{content}}
			</li>
			{{/each}}
			</ul>
			{{else}}
			<h2>검색 결과가 없습니다.</h2>
			{{/if}}
			</script>

			</div>
		</div>
		<div class="search-result box panel panel-default">
			<div class="search-result head author panel-heading">
				<h1>작성자 검색 결과</h1>
			</div>
			<div class="search-result body author panel-body">
			<script type="text/handlebars-template" id="author-result-template">
			{{#if this}}
			<ul>
			{{#each this}}
			<li class="list-item">
			<h3>{{title}}</h3><br>
			{{content}}
			</li>
			{{/each}}
			</ul>
			{{else}}
			<h2>검색 결과가 없습니다.</h2>
			{{/if}}
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
	<script src="<?php echo _DISTJS ?>/search.js"></script>

</body>

</html>