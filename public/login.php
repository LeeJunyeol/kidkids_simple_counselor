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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v2.11&appId=1799801130312500';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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
		<div id="naverIdLogin"><a id="naverIdLogin_loginButton" href="#"><img src="https://static.nid.naver.com/oauth/big_g.PNG?version=js-2.0.0" height="60"></a></div>
		<div id="kakaoIdLogin"><a id="custom-login-btn"><img src="//k.kakaocdn.net/14/dn/btqbjxsO6vP/KPiGpdnsubSq3a0PHEGUK1/o.jpg" width="300"></a></div>
		<div class="fb-login-button" scope="public_profile,email" onlogin="checkLoginState();"
		data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>

		<div id="status">
		</div>
	</article>
<?php
require_once "aside.php";
require_once "footer.php";
?>
	<script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
	<script src="<?php echo _NODE ?>/jquery.redirect/jquery.redirect.js"></script>
	<script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.0.js" charset="utf-8"></script>
	<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
	<script src="<?php echo _DISTJS ?>/login.js"></script>
	<script> 
		function checkLoginState() {
			FB.getLoginStatus(function(response) {
				statusChangeCallback(response);
			});
		}

		function statusChangeCallback(response) {
			console.log('statusChangeCallback');
			console.log(response);
			// The response object is returned with a status field that lets the
			// app know the current login status of the person.
			// Full docs on the response object can be found in the documentation
			// for FB.getLoginStatus().
			if (response.status === 'connected') {
				facebookLogin();
			} else {
				FB.login(function(response) {
					if (response.status === 'connected') {
						// Logged into your app and Facebook.
					} else {
						// The person is not logged into this app or we are unable to tell. 
					}
				});
			}
		}

		function facebookLogin() {
			FB.api('/me', function(res) {
				var user = {};
				user.id = res.id;
				user.name = res.name;
				$.ajax(location.origin + "/api/User/fblogin", {
					type: "POST",
					contentType: "application/json",
					data: JSON.stringify(user)
				}).then(function(res) { 
					window.location.replace("http://" + window.location.hostname + (location.port == "" || location.port == undefined ? "" : ":" + location.port) + "/home");
				});
			});
		};
	</script>
</body>

</html>