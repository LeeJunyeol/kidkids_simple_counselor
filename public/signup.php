<?php
require_once "config.php";
if(isset($_SESSION["message"])){
  $message = $_SESSION['message'];
  echo "<script>alert(\"" . $message . "\");</script>";
  session_unset();
}
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
if(isset($_SESSION['message']) && isset($_SESSION['logged_in'])){
	if(!$_SESSION['logged_in']){
		echo "<script>alert(".  $_SESSION['message'] .");</script>";
  }
  session_unset();
}
require_once "header.php";
?>
    <article class="signup">
		<!-- Modal -->
		<div id="myLogin" style="background: white; padding-bottom: 35px; padding-left: 35px; padding-right: 35px; padding-top: 15px;">
    <h1>회원가입</h1>


    <form action="/ksc/api/User" enctype="multipart/form-data" method="post" autocomplete="off" accept-charset="utf-8" onsubmit="return checkForm(this);">
    
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
        <input id="password" type="password" class="form-control" required autocomplete="off" name='password'/>
      </div>
      <div class="field-wrap">
        <label>
            비밀번호 확인<span class="req">*</span>
        </label>
        <input id="repassword" type="password" class="form-control" required autocomplete="off" name='repassword'/>
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
    <div class="field-wrap">
      <label>
        프로필사진<span class="req">*</span>
      </label>
      <input type="file" class="form-control" name="image" accept="image/*">
    </div>
    
    <button type="submit" id="btn-signup" name="register" class="btn btn-success btn-block" style="margin-top: 20px">
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
    <script src="<?php echo _DISTJS ?>/home.js"></script>
    <script>
    function checkForm(form) {
      if (form.id.value == "") {
        alert("아이디를 입력해주세요.");
        form.id.focus();
        return false;
      }
      re = /^\w+$/;
      if (!re.test(form.id.value)) {
        alert("Error: 아이디는 오직 문자열, 숫자, _ 만 포함해야 합니다.");
        form.id.focus();
        return false;
      }

      if (form.password.value != "" && form.password.value == form.repassword.value) {
        if (form.password.value.length < 6) {
          alert("비밀번호는 최소 6자리");
          form.password.focus();
          return false;
        }
      } else {
          alert("비밀번호를 제대로 입력했는지 확인해주세요.");
          form.password.focus();
          return false;
      }
      if(form.image.value == ""){
        alert("사진등록 해주세요.");
        form.image.focus();
        return false;
      }
      return true;
  }
    </script>

</body>

</html>