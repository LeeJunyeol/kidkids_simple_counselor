<style>
#imaginary_container{
    margin-top:10px;
}
.stylish-input-group .input-group-addon{
    background: white !important; 
}
.stylish-input-group .form-control{
	border-right:0; 
	box-shadow:0 0 0; 
	border-color:#ccc;
}
.stylish-input-group button{
    border:0;
    background:transparent;
}
</style>

<header>
    <div class="head center-block">
        <div class="logo">
            <nav>
                <ul class="nav nav-pills">
                    <li>
                        <button class="btn btn-default question">질문하기</button>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="title">
            <h1>키드키즈 고민상담소!</h1>
            <a href="http://localhost/ksc/home" id="logo">
                <img id="logoimg" src="<?php echo _IMG ?>/char_hooni.png" />
            </a>
        </div>
        <div id="user-container">
        <?php 
        if(isset($_SESSION["logged_in"])){
            $username = $_SESSION["name"];
            echo "<div data-id=".$_SESSION['id']." id='welcome' class='welcome'>
                <a href='#'>".$username."님 안녕하세요.</a>
            </div>";
        };
        ?>
            <div class="btn-group user-control">
            <?php 
            if(!isset($_SESSION["logged_in"])){
                echo "<button class='btn btn-default login'>로그인</button>";
                echo "<button class='btn btn-default signup'>회원가입</button>";
                
            } else {
                echo "<button class='btn btn-default mypage'>마이페이지</button>";
                echo "<button class='btn btn-default logout'>로그아웃</button>";
            }
            ?>
            </div>
        </div>
    </div>
</header>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div id="imaginary_container"> 
            <div class="input-group stylish-input-group">
                <input type="text" class="form-control"  placeholder="Search" >
                <span class="input-group-addon">
                    <button type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
        </div>
    </div>
</div>
<div id="main">
        <div class="wrapper center-block">
