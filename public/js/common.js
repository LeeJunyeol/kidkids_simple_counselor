$(document).ready(function () {
    $(".btn.login").on("click", function () {
        $("#myLoginModal").modal();
    })
    $(".btn.question").on("click", goToWrite);
    $(".category-box").on("click", ".category-item>div>a", goToHomeByCategory);
//    $(".login").on("click", login);
    $(".logout").on("click", logout);
    $("button.signup").on("click", goToSignup);
    $("a.btn-signup").on("click", goToSignup);
    
    function login(e){
        console.log("로그인");
        location.href = "http://localhost/ksc/public/login.php";
    }

    function logout(e){
        location.href = "http://localhost/ksc/public/logout.php";
    }

    function goToSignup() {
        location.href = location.origin + "/ksc/signup";
    }

    function goToWrite() {
        location.href = location.origin + "/ksc/write";
    }

    function goToHomeByCategory(e) {
        var category = $(this).text();
        location.href = "http://localhost/ksc/home?category=" + category;
    }
});