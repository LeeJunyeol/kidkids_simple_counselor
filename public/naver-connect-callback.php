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

	<script>
		window.addEventListener('load', function () {
            var code = location.search.match(/code=(.+)\&/)[1];
            var state = location.search.match(/state=(.+)/)[1];

            // 네아로 접근토큰 요청
            $.ajax("https://cors-anywhere.herokuapp.com/" + "https://nid.naver.com/oauth2.0/token", {
                type: 'GET',
                data: {
                    client_secret: "fYR1amNx2i",
                    client_id: "cbo8Ug2OQ_WcwqcbzP0O",
                    grant_type: "authorization_code",
                    code: code,
                    state: state
                }
            }).then(res => {
                // 네아로 프로필 정보 요청
                $.ajax("https://cors-anywhere.herokuapp.com/" + "https://openapi.naver.com/v1/nid/me", {
                    headers: {
                        Authorization: "Bearer " + res.access_token
                    }
                }).then(res => {
                    $.ajax(location.origin + "/api/User/naverconn", {
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            id: res.response.id
                        })
                    }).then(res => {
                        location.href = location.origin + "/my";
                    })
                })
            })
		});
	</script>
</body>

</html>