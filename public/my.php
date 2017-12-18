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
    <div id="top-container">
        <div id="profile-box">
            <div class="box" style="position: relative">
            <?php 
                $userType = $_SESSION['user_type'];
                if($userType == '전문가'){
                    echo "<div style='position: absolute; top: -40px; left: -8px; width: 80px; margin: auto;'>
                    <img src='http://localhost/ksc/public/images/giphy.gif' style='display: block; width: 33px; height: 33px; margin: auto;'>
                    <label class='my-label label label-info' style='display: block; padding: .3em .3em .3em; font-size: 130%;'>".$userType."</label></div>";
                    }?>
                <div class="my-image" style="width: 130px; height: 100%; margin-top: 6px;">
                    <img src=<?php echo "http://localhost/ksc/user_images/".$_SESSION['user_image']?> style="width: 100%; height: 100%" />
                </div>
                <div class="my-info">
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
                        <?php echo $_SESSION['myscore']; ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="rank-box">
            <div class="box">
                <h2>현재 순위</h2>
            
            </div>
        </div>
    </div>
    <div id="second-container">
        <div>
            <div class="box">
                <h2>최근 질문</h2>
                <ul class="question wrap">
                    <li class="question list-group-item" data-id={{question_id}}>
                        <div class="list-header">
                            <h3><a href="#" class="list-head">{{title}}</a></h3>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{modify_date}}</span>
                            조회수 <span class="view-cnt badge">{{view}}</span>
                            <ul class="tags"> 태그:  
                                <li class="tags">
                                    <span class="label label-info">{{this}}</span>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="question list-group-item" data-id={{question_id}}>
                        <div class="list-header">
                            <h3><a href="#" class="list-head">{{title}}</a></h3>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{modify_date}}</span>
                            조회수 <span class="view-cnt badge">{{view}}</span>
                            <ul class="tags"> 태그:  
                                <li class="tags">
                                    <span class="label label-info">{{this}}</span>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div>
            <div class="box">
                <h2>최근 답변</h2>
                <ul class="answer wrap">
                    <li class="answer list-group-item" data-id={{question_id}}>
                        <div class="list-header">
                            <h3><a href="#" class="list-head">{{title}}</a></h3>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{modify_date}}</span>
                            조회수 <span class="view-cnt badge">{{view}}</span>
                            <ul class="tags"> 태그:  
                                <li class="tags">
                                    <span class="label label-info">{{this}}</span>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="answer list-group-item" data-id={{question_id}}>
                        <div class="list-header">
                            <h3><a href="#" class="list-head">{{title}}</a></h3>
                        </div>
                        <div class="list-footer">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="date">{{modify_date}}</span>
                            조회수 <span class="view-cnt badge">{{view}}</span>
                            <ul class="tags"> 태그:  
                                <li class="tags">
                                    <span class="label label-info">{{this}}</span>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
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
    <script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
    <script src="<?php echo _JS ?>/util.js"></script>
    <script src="<?php echo _JS ?>/common.js"></script>
    <script src="<?php echo _JS ?>/my.js"></script>

</body>

</html>