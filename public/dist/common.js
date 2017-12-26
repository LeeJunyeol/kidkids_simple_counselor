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

exports.default = { AsideModule: AsideModule, CommonModule: CommonModule };

// $(document).ready(function () {
//     CommonModule.init();

//     // aside 템플릿이 있을 때, asdie 모듈을 초기화한다.
//     if ($("#nav-category-template").length > 0) AsideModule.init();
// });
},{}]},{},[1]);
