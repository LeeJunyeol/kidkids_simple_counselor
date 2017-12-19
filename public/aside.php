<style>
ul {
	list-style: none;
	padding-left: 0;
}

ul.sub {
	padding-left: 10px;
}

</style>
<aside id="rank-aside" class="rank-aside" data-category-id=<?php 
				if(isset($_GET['categoryId'])){
					echo $_GET['categoryId'];
					} else {
						echo 0;
					} ?>>
				<div class="category-box">
					<div id="category">
						<h3>카테고리</h3>
						<div class="wrapper">
							<ul>
								<li id="category-list">
									<a href="http://localhost/ksc/home"> 분류 전체 보기</a><br>
									<script type="text/handlebars-template" id="nav-category-template">
									{{#if currentCategory.parent_idx}}<a href="http://localhost/ksc/home?categoryId={{currentCategory.parent_idx}}">뒤로 가기</a><br>{{/if}}
									<a href="http://localhost/ksc/home?categoryId={{currentCategory.category_id}}">{{currentCategory.category_name}}</a>
									<ul class="sub">
										{{#each categories}}
										<li class="category-item" data-id={{category_id}} data-depth={{depth}} data-parent-idx={{parent_idx}}><a href="#">{{category_name}}</a></li>
										{{/each}}
									</ul>
									</script>
								</li>
							</ul>
						</div>
					</div>
                </div>
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
							<tbody id="rank-body">
								<script type="text/handlebars-template" id="rank-body-template">
								{{#each this}}
								<tr>
									<td class="rank-table-item rank">{{rank}}</td>
									<td class="rank-table-item id"><a href="http://localhost/ksc/user/{{user_id}}">{{user_id}}</a></td>
									<td class="rank-table-item score">{{score}}</td>
								</tr>
								{{/each}}
							</script>
							</tbody>

						</table>
					</div>

				</div>
			</aside>
		</div>
	</div>