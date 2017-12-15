var CommonModule = (function () {

    var BASE_URL = "http://localhost/ksc/";

    function init() {
        $(".btn.login").on("click", goToLogin);
        $(".btn.question").on("click", goToWrite);
        $(".category-box").on("click", ".category-item>div>a", goToHomeByCategory);
        $(".logout").on("click", logout);
        $("button.signup").on("click", goToSignup);
        $("a.btn-signup").on("click", goToSignup);
        $("button.mypage").on("click", goToMyPage);

        // 본문에 모든 a태그 디폴트를 없앰
        $("article").on("click", "a", function (e) {
            e.preventDefault();
        })

        renderRankBox();
    }

    function goToLogin() {
        location.href = BASE_URL + "/login"
    }

    function goToMyPage() {
        location.href = BASE_URL + "/my";
    }

    function renderRankBox() {
        var rankBodyTemplate = handlebarsHelper("#rank-body-template");

        $.ajax(BASE_URL + "/api/Rank", {
            type: 'GET',
            data: {
                ranker: true
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            var rankers = result['ranker'];
            rankers.map(function (v, i) {
                v['rank'] = ++i;
            })
            $("#rank-body").html(rankBodyTemplate(rankers));
        })
    }

    function logout(e) {
        location.href = BASE_URL + "/public/logout.php";
    }

    function goToSignup() {
        location.href = location.origin + "/ksc/signup";
    }

    function goToWrite() {
        location.href = location.origin + "/ksc/write";
    }

    function goToHomeByCategory(e) {
        var category = $(this).text();
        location.href = BASE_URL + "/home?category=" + category;
    }

    return {
        init
    }
})();

$(document).ready(function () {
    CommonModule.init()
});