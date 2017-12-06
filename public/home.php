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
    <link href="<?php echo _CSS?>/index.css" rel="stylesheet">
</head>

<body>
<?php
require_once "header.php";
?>

	<div id="main">
		<div class="wrapper center-block">
			<!-- 카테고리 링크 -->
			<aside class="category-aside">
				<div class="category-box">
					<div class="head category-head">
						<h3>카테고리</h3>
					</div>

					<div class="category-item">
						<div>육아
							<br>/건강</div>
					</div>
					<div class="category-item">
						<div>교육
							<br>/놀이</div>
					</div>
					<div class="category-item">
						<div>안전</div>
					</div>
					<div class="category-item">
						<div>음식</div>
					</div>
					<div class="category-item">
						<div>기타</div>
					</div>
				</div>
			</aside>

			<!-- 메인 -->
			<article class="index">
				<div id="board-header">
					<div class="title">
						<h2>전체 질문</h2>
					</div>
					<div class="btn-order">
						<a href="#">최신순</a>
						<a href="#">조회순</a>
					</div>
				</div>
				<div class="board">
					<ul class="list-group">
						<li class="list-group-item">
							<span class="badge">14</span>
							<p>
								<a href="#" class="list-head">질문</a>
								<br>
								<div class="list-footer">
									<span class="author">이준열</span>
									<span class="date">2017-12-04</span>
									<ul class="tags">
										<li class="tags">
											<span class="label label-info">태그1</span>
										</li>
										<li class="tags">
											<span class="label label-info">태그2</span>
										</li>
										<li class="tags">
											<span class="label label-info">태그3</span>
										</li>
									</ul>
								</div>
							</p>
						</li>
						<li class="list-group-item">
							<span class="badge">14</span>
							<p>
								<a href="#" class="list-head">질문</a>
								<br>
								<div style="display: flex;">
									<span class="author" style="margin-right: 10px;">이준열</span>
									<span class="date">2017-12-04</span>
									<ul class="tags" style="list-style: none;">
										<li class="tags" style="float: left;">
											<span class="label label-info">태그1</span>
										</li>
										<li class="tags" style="float: left;">
											<span class="label label-info">태그2</span>
										</li>
										<li class="tags" style="float: left;">
											<span class="label label-info">태그3</span>
										</li>
									</ul>
								</div>
							</p>
						</li>
						<li class="list-group-item">
							<span class="badge">14</span>
							<p>
								<a href="#" class="list-head">질문</a>
								<br>
								<div style="display: flex;">
									<span class="author" style="margin-right: 10px;">이준열</span>
									<span class="date">2017-12-04</span>
									<ul class="tags" style="list-style: none;">
										<li class="tags" style="float: left;">
											<span class="label label-info">태그1</span>
										</li>
										<li class="tags" style="float: left;">
											<span class="label label-info">태그2</span>
										</li>
										<li class="tags" style="float: left;">
											<span class="label label-info">태그3</span>
										</li>
									</ul>
								</div>
							</p>
						</li>
					</ul>
				</div>
			</article>

			<aside class="rank-aside">
				<div class="rank-box">
					<div class="head rank-head">
						<h3>지식 랭킹</h3>
					</div>
					<div>
						<table class="rank-table">
							<thead>
								<tr>
									<th class="rank-table-head rank">순위</th>
									<th class="rank-table-head id">아이디</th>
									<th class="rank-table-head score">점수</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="rank-table-item rank">1</td>
									<td class="rank-table-item id">PHP</td>
									<td class="rank-table-item score">100</td>
								</tr>
								<tr>
									<td class="rank-table-item rank">2</td>
									<td class="rank-table-item id">JS</td>
									<td class="rank-table-item score">80</td>
								</tr>
								<tr>
									<td class="rank-table-item rank">3</td>
									<td class="rank-table-item id">mySQL</td>
									<td class="rank-table-item score">77</td>
								</tr>
							</tbody>

						</table>
					</div>

				</div>
			</aside>
		</div>
	</div>

<?php
require_once "footer.php";
?>
    <script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
	<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?php echo _JS ?>/index.js"></script>
	<script src="<?php echo _JS ?>/common.js"></script>
</body>

</html>