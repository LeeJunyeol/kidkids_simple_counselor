		<style>
		footer {
			background: #2A2730;
			padding-top: 60px;
			padding-bottom: 60px;
			margin-top: 100px;
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
		<!-- Modal -->
		<div class="modal fade" id="myLoginModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header" style="padding: 10px 35px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>
							<span class="glyphicon glyphicon-lock"></span> 로그인</h4>
					</div>
					<div class="modal-body" style="padding:40px 50px;">
						<form role="form">
							<div class="form-group">
								<label for="usrname">
									<span class="glyphicon glyphicon-user"></span> 아이디</label>
								<input type="text" class="form-control" id="usrname" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="psw">
									<span class="glyphicon glyphicon-eye-open"></span> 비밀번호</label>
								<input type="text" class="form-control" id="psw" placeholder="Enter password">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" value="" checked>아이디 기억하기</label>
							</div>
							<button type="submit" class="btn btn-success btn-block">
								<span class="glyphicon glyphicon-off"></span> 로그인</button>
						</form>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger btn-default" data-dismiss="modal" style="height: 50%; min-height: 34px;">
							<span class="glyphicon glyphicon-remove"></span> 취소</button>

						<div>
							<p>회원이 아니신가요?
								<a class="btn-signup" href="#">회원가입</a>
							</p>
							<p>
								<a href="#">비밀번호</a>를 잊으셨나요?</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>