<?php
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="kr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NaverLoginSDK</title>
</head>

<body>
	<!-- (1) LoginWithNaverId Javscript SDK -->
	<script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.0.js" charset="utf-8"></script>

	<!-- (2) LoginWithNaverId Javscript 설정 정보 및 초기화 -->
	<script>
		var naverLogin = new naver.LoginWithNaverId(
			{
				clientId: "cbo8Ug2OQ_WcwqcbzP0O",
				callbackUrl: location.origin + "/naver-callback",
				isPopup: false,
				callbackHandle: true
				/* callback 페이지가 분리되었을 경우에 callback 페이지에서는 callback처리를 해줄수 있도록 설정합니다. */
			}
		);

		/* (3) 네아로 로그인 정보를 초기화하기 위하여 init을 호출 */
		naverLogin.init();

		/* (4) Callback의 처리. 정상적으로 Callback 처리가 완료될 경우 main page로 redirect(또는 Popup close) */
		window.addEventListener('load', function () {
			naverLogin.getLoginStatus(function (status) {
				if (status) {
					/* (5) 필수적으로 받아야하는 프로필 정보가 있다면 callback처리 시점에 체크 */
					var user = {};
                    user.email = naverLogin.user.getEmail();
                    user.name = naverLogin.user.getNickName();
                    user.pic = naverLogin.user.getProfileImage();
                    user.birthday = naverLogin.user.getBirthday();			
                    user.id = naverLogin.user.getId();
                    user.age = naverLogin.user.getAge();
					if( user.email == undefined || user.email == null) {
						alert("이메일은 필수정보입니다. 정보제공을 동의해주세요.");
						/* (5-1) 사용자 정보 재동의를 위하여 다시 네아로 동의페이지로 이동함 */
						naverLogin.reprompt();
						return;
					}
					
					$.ajax(location.origin + "/api/User/naverlogin", {
						type: 'POST',
						contentType: 'application/json',
						data: JSON.stringify(user)
					}).then(function(res){
						window.location.replace("http://" + window.location.hostname + ( (location.port==""||location.port==undefined)?"":":" + location.port) + "/home");
					})
				} else {
					console.log("callback 처리에 실패하였습니다.");
				}
			});
		});
	</script>
</body>

</html>