<aside class="rank-aside">
				<div class="category-box">
                    <div class="head category-head">
                        <h3>카테고리</h3>
                    </div>
                    <div class="category-item">
                        <div><a href="http://localhost/ksc/home">전체</a></div>
                    </div>
                    <div class="category-item">
                        <div><a href="#" data-category="육아/건강">육아/건강</a></div>
                    </div>
                    <div class="category-item">
                        <div><a href="#" data-category="교육/놀이">교육/놀이</a></div>
                    </div>
                    <div class="category-item">
                        <div><a href="#" data-category="안전">안전</a></div>
                    </div>
                    <div class="category-item">
                        <div><a href="#" data-category="음식">음식</a></div>
                    </div>
                    <div class="category-item">
                        <div><a href="#" data-category="기타">기타</a></div>
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
									<td class="rank-table-item id">{{user_id}}</td>
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