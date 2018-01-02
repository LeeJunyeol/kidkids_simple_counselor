<?php
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>키고상: 마이페이지</title>
    <link href="<?php echo _NODE?>/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo _CSS?>/common.css" rel="stylesheet">
	<link href="<?php echo _CSS?>/my.css" rel="stylesheet">
</head>

<body>
<?php
require_once "header.php";
?>
<article>
    <div id="top-container" class="wrapper-container">
        <div id="profile-box" class="box-wrapper">
            <div class="box">
            <?php 
                $userType = $_SESSION['user_type'];
                if($userType == '전문가'){
                    echo "<div style='position: absolute; top: -40px; left: -8px; width: 80px; margin: auto;'>
                    <img src='/public/images/giphy.gif' style='display: block; width: 33px; height: 33px; margin: auto;'>
                    <label class='my-label label label-info' style='display: block; padding: .3em .3em .3em; font-size: 130%;'>".$userType."</label></div>";
                    }?>
                <div class="my-image" style="width: 200px; height: 100%; margin-top: 6px;">
                    <img src=<?php echo $_SESSION['user_image']?> style="width: 100%; height: 100%" />
                </div>
                <div class="my-info" style="width: 100%; position: relative;">
                    <div class="edit-btn-group btn-group" style="position: absoulte; left: 79%; top: 0;">
                        <button type="button" class="btn btn-default edit" aria-label="Left Align">
                            <span class="edit glyphicon glyphicon glyphicon-pencil" aria-hidden="true">수정</span>
                        </button>
                        <button type="button" class="btn btn-default delete" aria-label="Left Align" style="margin-left: -5px;">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true">회원 탈퇴</span>
                        </button>
                    </div>
                    <div class="profile-area">
                        <div>
                            <h2><span><?php echo $_SESSION['name']; ?></span></h2>
                        </div>
                        <div>
                            <label>이메일: </label>
                            <span><?php echo $_SESSION['email']; ?></span>
                        </div>
                    </div>
                    <div class="score-area">
                        <?php 
                            $myscore = 0;
                            if(isset($_SESSION['myscore'])) {
                                $myscore = $_SESSION['myscore'];
                            }
                            $scorePer = $myscore / 500 * 100;
                            $level = floor($scorePer / 100);
                            $scorePer = $scorePer - $level * 100;
                        ?>
                        <h3>레벨: <?php echo $level ?></h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $myscore;?>"
                            aria-valuemin="0" aria-valuemax="500" style="width: <?php echo $scorePer; ?>%">
                            <span class="sr-only">10% Complete (success)</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div id="rank-box">
            <div class="box">
                <script type="text/handlebars-template" id="current-rank-template">
                <h3 class="text-center" style="margin-bottom: 10px";>현재 순위</h3>
                <table class="rank-table table table-striped" style="border-top: 2px solid #ddd;">
                    <thead>
                        <tr>
                            <th class="rank-table-head rank">순위</th>
                            <th class="rank-table-head id">아이디</th>
                            <th class="rank-table-head score">점수</th>
                        </tr>
                    </thead>
                    <tbody id="rank-body">
                        {{#each this}}
                        <tr>
                            <td class="rank-table-item rank">{{rank}}</td>
                            <td class="rank-table-item id"><a href="/user/{{user_id}}">{{user_id}}</a></td>
                            <td class="rank-table-item score">{{score}}</td>
                        </tr>
                        {{/each}}
                    </tbody>
                </table>

                </script>
            </div>
        </div>
    </div>
    <div id="second-container">
        <div class="box-wrapper">
            <div id="question-box" class="box">
                <h2>최근 질문</h2>
                <script type="text/handlebars-template" id="recent-question-template">
                <ul class="question wrap">
                    {{#each this}}
                    <li class="question list-group-item" data-id={{question_id}}>
                        <div class="list-header">
                            <h3><a href="{{link}}" class="list-head">{{title}}</a></h3>
                        </div>
                        <div class="list-main">
                            <p>{{content}}</p>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{create_date}}</span>
                        </div>
                    </li>
                    {{/each}}
                </ul>
                </script>
            </div>
        </div>
        <div class="box-wrapper">
            <div id="answer-box" class="box">
                <h2>최근 답변</h2>
                <script type="text/handlebars-template" id="recent-answer-template">
                <ul class="answer wrap">
                    {{#each this}}
                    <li class="answer list-group-item" data-id={{answer_id}}>
                        <div class="list-header">
                            <h3><a href="{{link}}" class="list-head">{{question_id}}번에 대한 답변입니다.</a></h3>
                        </div>
                        <div class="list-main">
                            <span>{{content}}</span>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{create_date}}</span>
                        </div>
                    </li>
                    {{/each}}
                </ul>
                </script>
            </div>
        </div>
    </div>
    <div id="third-container" class="wrapper-container">
        <div id="sns-box" class="box-wrapper">
            <div class="box">
                <div id="sns-header">
                    <h1>SNS 계정 연동관리</h1>
                </div>
                <section id="sns-body">
                <script type="text/handlebars-template" id="sns-conn-template">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>SNS 구분</th>
                                <th>연동정보</th>
                                <th>연결</th>
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="/public/images/naver.png" /></td>
                                <td></td>
                                {{#if naver_id}}
                                <td><div id="naverIdDisconn"><button class="btn btn-danger">연동해제</button></div></td>
                                {{else}}
                                <td><div id="naverIdConn"><button class="btn btn-default">연결하기</button></div></td>
                                {{/if}}
                            </tr>
                            <tr>
                                <td><img src="/public/images/kakao.png" /></td>
                                <td></td>
                                {{#if kakao_id}}
                                <td><div id="kakaoIdDisconn"><button class="btn btn-danger">연동해제</button></div></td>
                                {{else}}
                                <td><div id="kakaoIdLogin"><button class="btn btn-default">연결하기</button></div></td>
                                {{/if}}
                            </tr>
                            <tr>
                                <td><img src="/public/images/facebook.png" /></td>
                                <td></td>
                                {{#if fb_id}}
                                <td><div id="fbIdDisconn"><button class="btn btn-danger">연동해제</button></div></td>
                                {{else}}
                                <td><div id="fbIdLogin"><button class="btn btn-default">연결하기</button></div></td>
                                {{/if}}
                            </tr>
                        <tbody>
                    </table>
                </script>
                </section>
            </div>
        </div>
    </div>

</article>
</div>

    
<?php
require_once "footer.php";
?>
    <script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
    <script src="<?php echo _NODE ?>/jquery.redirect/jquery.redirect.js"></script>
    <script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.0.js" charset="utf-8"></script>
	<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <script src="<?php echo _DISTJS ?>/my.js"></script>
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
				testAPI();
			} else {
			// The person is not logged into your app or we are unable to tell.
			document.getElementById('status').innerHTML = 'Please log ' +
				'into this app.';
			}
		}

		function testAPI() {
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