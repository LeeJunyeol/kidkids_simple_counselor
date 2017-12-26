import { HandlebarsHelper, Utils } from "./util";

var AsideModule = (function() {
  var BASE_URL = location.origin + "/ksc";

  var init = function() {
    var navCategoryTemplate = HandlebarsHelper("#nav-category-template");
    var categoryId = $("#rank-aside").data("category-id");

    $("#category-list").on("click", ".category-item>a", goToHomeByCategory);

    renderCategory(navCategoryTemplate, categoryId);
    renderRankBox();
  };

  var renderCategory = function(navCategoryTemplate, categoryId) {
    $.ajax(BASE_URL + "/api/Category", {
      type: "GET",
      data: {
        categoryId: categoryId
      }
    }).then(function(res) {
      var result = JSON.parse(res);
      // categories = result['categories'];
      var $categoryList = $("#category-list");
      $categoryList.append(navCategoryTemplate(result));
    });
  };

  var goToHomeByCategory = function(e) {
    var $listItem = $(e.currentTarget).closest("li");
    location.href =
      BASE_URL +
      "/home?categoryId=" +
      $listItem.data("id") +
      "&categoryName=" +
      $(e.currentTarget).text();
  };

  var renderRankBox = function() {
    var rankBodyTemplate = HandlebarsHelper("#rank-body-template");

    $.ajax(BASE_URL + "/api/Rank", {
      type: "GET",
      data: {
        ranker: true
      }
    }).then(function(res) {
      var result = JSON.parse(res);
      var rankers = result["ranker"];
      rankers.map(function(v, i) {
        v["rank"] = ++i;
      });
      $("#rank-body").html(rankBodyTemplate(rankers));
    });
  };

  return {
    init: init
  };
})();

var CommonModule = (function() {
  var BASE_URL = location.origin + "/ksc";

  function init() {
    $(".btn.login").on("click", goToLogin);
    $(".btn.question").on("click", goToWrite);
    $(".logout").on("click", logout);
    $("button.signup").on("click", goToSignup);
    $("a.btn-signup").on("click", goToSignup);
    $("button.mypage").on("click", goToMyPage);

    $("#search-btn").on("click", function(e) {
      search(
        $(e.currentTarget)
          .closest("div.input-group")
          .find("input")
          .val()
      );
    });
  }

  function search(keywords) {
    location.href =
      BASE_URL + "/search?search=" + keywords + "&category=" + "all";
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
})();

export { AsideModule, CommonModule };
