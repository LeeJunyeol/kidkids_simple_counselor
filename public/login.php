<?php
require_once "config.php";
if(isset($_SESSION["logged_in"])){
	echo "<script>alert(\"이미 로그인 되어 있습니다.\");
	location.href=\"/home\"</script>";
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
	<link href="<?php echo _CSS?>/index.css" rel="stylesheet">
</head>

<body>
<?php
if(isset($_SESSION["message"])){
	$message = $_SESSION['message'];
	echo "<script>alert(\"" . $message . "\");</script>";
	session_unset();
}
require_once "header.php";
?>
    <article class="login">
		<!-- Modal -->
		<div id="myLogin" style="background: white;">
			<div class="login-dialog">
				<!-- Modal content-->
				<div class="login-content">
					<div class="login-header" style="padding: 10px 35px;">
						<button type="button" class="close">&times;</button>
						<h1>로그인</h1>
					</div>
					<div class="login-body" style="padding:0px 50px;">
						<form role="form" action="/api/User" method="post" accept-charset="utf-8">
							<div class="form-group">
								<label for="usrname">
									<span class="glyphicon glyphicon-user"></span> 아이디</label>
								<input type="text" class="form-control" name="id" placeholder="Enter ID">
							</div>
							<div class="form-group">
								<label for="psw">
									<span class="glyphicon glyphicon-eye-open"></span> 비밀번호</label>
								<input type="password" class="form-control" name="password" placeholder="Enter password">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" value="" disabled>아이디 기억하기</label>
							</div>
							<button type="submit" id="btn-login" name="login" class="btn btn-success btn-block">
								<span class="glyphicon glyphicon-off"></span> 로그인</button>
						</form>
					</div>
					<div class="login-footer" style="display: flex; justify-content: flex-end; padding-top: 20px; padding-left: 50px; padding-right: 50px; align-items: end;">
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
		<?php
			// 네이버 로그인 접근토큰 요청 예제
			$client_id = "cbo8Ug2OQ_WcwqcbzP0O";
			$redirectURI = urlencode("http://localhost/naver");
			$state = "RAMDOM_STATE";
			$apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;
		?>
		<a href="<?php echo $apiURL ?>"><img height="50" src="http://static.nid.naver.com/oauth/small_g_in.PNG"/></a>
    </article>
<?php
require_once "aside.php";
require_once "footer.php";
?>
	<script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
	<script src="<?php echo _NODE ?>/jquery.redirect/jquery.redirect.js"></script>
	<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?php echo _DISTJS ?>/login.js"></script>
</body>

</html>