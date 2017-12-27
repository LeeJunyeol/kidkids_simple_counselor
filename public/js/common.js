var AsideModule = (function () {
    var BASE_URL = location.origin,
        rankBodyTemplate = handlebarsHelper("#rank-body-template"),
        navCategoryTemplate = handlebarsHelper("#nav-category-template"),

        $categoryList = $("#category-list"),

        categoryId = $("#rank-aside").data("category-id");

    var init = function () {
        $categoryList.on("click", ".category-item>a", goToHomeByCategory);

        renderCategory(navCategoryTemplate, categoryId);
        renderRankBox();
    }

    var goToHomeByCategory = function (e) {
        $listItem = $(e.currentTarget).closest("li");
        location.href = BASE_URL + "/home?categoryId=" + $listItem.data("id") + "&categoryName=" + $(e.currentTarget).text();
    }

    var renderCategory = function (navCategoryTemplate, categoryId) {
        $.ajax(BASE_URL + "/api/Category", {
            type: 'GET',
            data: {
                categoryId: categoryId
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            $categoryList.append(navCategoryTemplate(result));
        })
    }

    var renderRankBox = function () {
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

    return {
        init: init
    }
})();

var CommonModule = (function () {
    var BASE_URL = location.origin + "";

    function init() {
        $(".btn.login").on("click", goToLogin);
        $(".btn.question").on("click", goToWrite);
        $(".logout").on("click", logout);
        $("button.signup").on("click", goToSignup);
        $("a.btn-signup").on("click", goToSignup);
        $("button.mypage").on("click", goToMyPage);

        $("#search-btn").on("click", function (e) {
            search($(e.currentTarget).closest("div.input-group").find("input").val());
        });
    }

    function search(keywords) {
        location.href = BASE_URL + "/search?search=" + keywords + "&category=" + "all";
    }

    function goToLogin() {
        location.href = BASE_URL + "/login";
    }

    function goToMyPage() {
        location.href = BASE_URL + "/my";
    }

    function logout(e) {
        location.href = BASE_URL + "/public/logout.php";
    }

    function goToSignup() {
        location.href = BASE_URL + "/signup";
    }

    function goToWrite() {
        location.href = BASE_URL + "/write";
    }

    return {
        init: init
    }
})();

<<<<<<< HEAD
$(document).ready(function () {
    CommonModule.init();

    // aside 템플릿이 있을 때, asdie 모듈을 초기화한다.
    if ($("#nav-category-template").length > 0) AsideModule.init();
});
=======
export { AsideModule, CommonModule };
>>>>>>> 77420720a99ec5964857328b9f23c8f8606679de
