var CommonModule = (function () {

    var BASE_URL = "http://localhost/ksc";
    var categories = [];
    var categoryId = $("#rank-aside").data("category-id");
    
    var navCategoryTemplate = handlebarsHelper("#nav-category-template");

    function init() {
        $(".btn.login").on("click", goToLogin);
        $(".btn.question").on("click", goToWrite);
        $("#category-list").on("click", ".category-item>a", goToHomeByCategory);
        $(".logout").on("click", logout);
        $("button.signup").on("click", goToSignup);
        $("a.btn-signup").on("click", goToSignup);
        $("button.mypage").on("click", goToMyPage);

        // 본문에 모든 a태그 디폴트를 없앰
        $("article").on("click", "a", function (e) {
            e.preventDefault();
        })

        renderCategory(categoryId);
        renderRankBox();
    }

    function renderCategory(categoryId) {
        $.ajax(BASE_URL + "/api/Category", {
            type: 'GET',
            data: {
                categoryId
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            // categories = result['categories'];
            var $categoryList = $("#category-list");
            $categoryList.append(navCategoryTemplate(result));
        })
    }

    function appendSubCategory($target, subCategories){
        $target.append(navCategoryTemplate(subCategories));
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
        $listItem = $(e.currentTarget).closest("li");
        location.href = BASE_URL + "/home?categoryId=" + $listItem .data("id") + "&categoryName=" + $(e.currentTarget).text();
    }

    return {
        init
    }
})();

$(document).ready(function () {
    CommonModule.init()
});