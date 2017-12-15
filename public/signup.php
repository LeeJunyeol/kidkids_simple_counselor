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
    <link href="<?php echo _CSS?>/index.css" rel="stylesheet">
  </head>
<body>
<?php
require_once "header.php";
?>
    <article class="signup">
		<!-- Modal -->
		<div id="myLogin" style="background: white; padding-bottom: 35px; padding-left: 35px; padding-right: 35px; padding-top: 15px;">
    <h1>회원가입</h1>
    <form action="http://localhost/ksc/api/User" method="post" autocomplete="off" accept-charset="utf-8">
    
    <style>
    label {
      width: 100px;
    }

    </style>
    <div class="top-row">
      <div class="field-wrap">
        <label>
          아이디<span class="req">*</span>
        </label>
        <input type="text" class="form-control" required autocomplete="off" name='id' />
      </div>
      <div class="field-wrap">
        <label>
            비밀번호<span class="req">*</span>
        </label>
        <input type="password" class="form-control" required autocomplete="off" name='password'/>
      </div>
      <div class="field-wrap">
        <label>
          이름<span class="req">*</span>
        </label>
        <input type="text" class="form-control" required autocomplete="off" name='name' />
      </div>
    </div>
    <div class="field-wrap">
      <label>
        이메일<span class="req">*</span>
      </label>
      <input type="email" class="form-control" required autocomplete="off" name='email' />
    </div>
    
    <button type="submit" id="btn-login" name="register" class="btn btn-success btn-block" style="margin-top: 20px">
								<span class="glyphicon glyphicon-off"></span> 가입신청</button>
  
    </form>
		</div>
    </article>
<?php
require_once "aside.php";
require_once "footer.php";
?>
    <script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
    <script src="<?php echo _NODE ?>/jquery.redirect/jquery.redirect.js"></script>
    <script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
    <script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
    <script src="<?php echo _JS ?>/util.js"></script>
    <script src="<?php echo _JS ?>/common.js"></script>

</body>

</html>