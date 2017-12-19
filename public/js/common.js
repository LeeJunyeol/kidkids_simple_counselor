var BASE_URL = "http://localhost/ksc";

var AsideModule = (function () {
    
    var init = () => {
        var navCategoryTemplate = handlebarsHelper("#nav-category-template");
        var categoryId = $("#rank-aside").data("category-id");

        $("#category-list").on("click", ".category-item>a", goToHomeByCategory);
        
        renderCategory(navCategoryTemplate, categoryId);
        renderRankBox();
    }

    var renderCategory = (navCategoryTemplate, categoryId) => {
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

    var goToHomeByCategory = (e) => {
        $listItem = $(e.currentTarget).closest("li");
        location.href = BASE_URL + "/home?categoryId=" + $listItem.data("id") + "&categoryName=" + $(e.currentTarget).text();
    }

    var renderRankBox = () => {
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

    return {
        init
    }

})();


var CommonModule = (function () {

    function init() {
        $(".btn.login").on("click", goToLogin);
        $(".btn.question").on("click", goToWrite);
        $(".logout").on("click", logout);
        $("button.signup").on("click", goToSignup);
        $("a.btn-signup").on("click", goToSignup);
        $("button.mypage").on("click", goToMyPage);

        $("#search-btn").on("click", (e) => {
            search($(e.currentTarget).closest("div.input-group").find("input").val());
        });
    }

    function search(keywords) {
        location.href = "http://localhost/ksc/search?search=" + keywords + "&category=" + "all";
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
        location.href = location.origin + "/ksc/signup";
    }

    function goToWrite() {
        location.href = location.origin + "/ksc/write";
    }

    return {
        init
    }
})();

$(document).ready(function () {
    CommonModule.init();
    if ($("#nav-category-template").length > 0) AsideModule.init();
});