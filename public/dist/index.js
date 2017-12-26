(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});
var AsideModule = function () {
    var BASE_URL = location.origin + "/ksc";

    var init = function init() {
        var navCategoryTemplate = handlebarsHelper("#nav-category-template");
        var categoryId = $("#rank-aside").data("category-id");

        $("#category-list").on("click", ".category-item>a", goToHomeByCategory);

        renderCategory(navCategoryTemplate, categoryId);
        renderRankBox();
    };

    var renderCategory = function renderCategory(navCategoryTemplate, categoryId) {
        $.ajax(BASE_URL + "/api/Category", {
            type: 'GET',
            data: {
                categoryId: categoryId
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            // categories = result['categories'];
            var $categoryList = $("#category-list");
            $categoryList.append(navCategoryTemplate(result));
        });
    };

    var goToHomeByCategory = function goToHomeByCategory(e) {
        $listItem = $(e.currentTarget).closest("li");
        location.href = BASE_URL + "/home?categoryId=" + $listItem.data("id") + "&categoryName=" + $(e.currentTarget).text();
    };

    var renderRankBox = function renderRankBox() {
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
            });
            $("#rank-body").html(rankBodyTemplate(rankers));
        });
    };

    return {
        init: init
    };
}();

var CommonModule = function () {
    var BASE_URL = location.origin + "/ksc";

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
    };
}();

exports.AsideModule = AsideModule;
exports.CommonModule = CommonModule;

// $(document).ready(function () {
//     CommonModule.init();

//     // aside 템플릿이 있을 때, asdie 모듈을 초기화한다.
//     if ($("#nav-category-template").length > 0) AsideModule.init();
// });
},{}],2:[function(require,module,exports){
"use strict";

var _common = require("./common");

$(document).ready(function () {
    _common.AsideModule.init();
    _common.CommonModule.init();

    var BASE_URL = location.origin + "/ksc";
    var API_BASE_URL = location.origin + "/ksc/api";
    var QUESTION_URL = API_BASE_URL + "/Question/";
    var MY_QUESTION_URL = API_BASE_URL + "/my/Question/";

    var url = "";

    var questionTemplateScript = $("#questions-template").html();
    var questionTemplate = Handlebars.compile(questionTemplateScript);

    var paginationTemplateScript = $("#pagination-template").html();
    var paginationTemplate = Handlebars.compile(paginationTemplateScript);

    var currentPageNum = 1;
    var lastPageNum = 1;

    var categoryId = $("#rank-aside").data("category-id");
    var sortBy = "default";
    var isAsc = false;

    init();

    function init() {
        getQuestions(1, sortBy, categoryId);

        // 페이지 네비게이션 이벤트
        $("#pageNav").on("click", "li.previous", prevPage);
        $("#pageNav").on("click", "li.next", nextPage);
        $("#pageNav").on("click", "li.pageNum", moveToPageNum);

        // 제목 클릭하면 이동 이벤트
        $("div.board>ul.list-group").on("click", ".list-header a", function (e) {
            e.preventDefault();
            var questionId = $(this).closest("li").data("id");
            $.ajax(BASE_URL + "/api/Question/" + questionId, {
                type: "PUT",
                contentType: "application/json",
                data: JSON.stringify({
                    view: parseInt($(this).closest("li.question").find("span.view-cnt").text())
                })
            }).then(function (res) {
                $.redirect("question/" + questionId, {
                    "question_id": questionId
                });
            });
        });

        // 최신순 조회순
        $("#btn-order-box").on("click", ".btn-order", function (e) {
            e.preventDefault();
            if ($(this).hasClass("latest")) {
                sortBy = "latest";
            } else {
                sortBy = "cnt";
            }
            $(this).toggleClass("isasc");
            $(this).hasClass("isasc") ? isAsc = true : isAsc = false;

            getQuestions(currentPageNum, sortBy, categoryId);
        });
    }

    function prevPage(e) {
        if (currentPageNum > 1) {
            currentPageNum--;
            getQuestions(currentPageNum, sortBy, categoryId);
        } else {
            alert("첫 페이지입니다.");
        }
    }

    function nextPage(e) {
        if (currentPageNum < lastPageNum) {
            currentPageNum++;
            getQuestions(currentPageNum, sortBy, categoryId);
        } else {
            alert("마지막 페이지입니다.");
        }
    }

    function moveToPageNum(e) {
        currentPageNum = parseInt($(e.currentTarget).data("num"));
        getQuestions(currentPageNum, sortBy, categoryId);
    }

    // 질문 목록을 불러온다.
    function getQuestions(page, sortBy, categoryId) {
        var dataObj = {};
        dataObj['page'] = page;
        dataObj['sortBy'] = sortBy;
        dataObj['isASC'] = isAsc;
        dataObj['limit'] = 5;
        if (categoryId !== 0) {
            dataObj['categoryId'] = categoryId;
        }
        $.ajax(BASE_URL + "/api/Controllers/Question.php", {
            type: "GET",
            contentType: "application/json",
            data: dataObj
        }).then(function (res) {
            var result = JSON.parse(res);
            var questions = result['questions'];

            for (var i = 0; i < questions.length; i++) {
                questions[i].modify_date = Utils.getFormatDate(questions[i].modify_date);
                questions[i].tags = questions[i].tags.split("/");
            }

            $("div.board > ul.list-group").html(questionTemplate(questions));

            var arr = [];
            for (lastPageNum = 0; lastPageNum < parseInt(result['count']) / 5; lastPageNum++) {
                arr.push(lastPageNum + 1);
            }
            $("ul.pagination").html(paginationTemplate(arr));
        });
    }
}); // import jQuery from "../node_modules/jquery/dist/jquery";
// window.$ = window.jQuery = jQuery;
},{"./common":1}]},{},[2]);
