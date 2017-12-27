import { HandlebarsHelper, Utils } from "./util";

var AsideModule = (() => {
  var BASE_URL = location.origin + "/ksc";

  var $categoryList = $("#category-list");

  var navCategoryTemplate = HandlebarsHelper("#nav-category-template");
  var rankBodyTemplate = HandlebarsHelper("#rank-body-template");

  var init = () => {
    var categoryId = $("#rank-aside").data("category-id");

    $categoryList.on("click", ".category-item>a", goToHomeByCategory);

    renderCategory(categoryId);
    renderRankBox();
  };

  var renderCategory = categoryId => {
    $.ajax(BASE_URL + "/api/Category", {
      type: "GET",
      data: {
        categoryId: categoryId
      }
    }).then(res => {
      var result = JSON.parse(res);
      $categoryList.html(navCategoryTemplate(result));
    });
  };

  var goToHomeByCategory = e => {
    e.preventDefault();
    e.stopPropagation();

    var $listItem = $(e.currentTarget).closest("li");
    location.href =
      BASE_URL +
      "/home?categoryId=" +
      $listItem.data("id") +
      "&categoryName=" +
      $(e.currentTarget).text();
  };

  var renderRankBox = () => {
    $.ajax(BASE_URL + "/api/Rank", {
      type: "GET",
      data: {
        ranker: true
      }
    }).then(res => {
      var result = JSON.parse(res);
      var rankers = result["ranker"];
      rankers.map((v, i) => {
        v["rank"] = ++i;
      });
      $("#rank-body").html(rankBodyTemplate(rankers));
    });
  };

  return {
    init: init
  };
})();

var CommonModule = (() => {
  var BASE_URL = location.origin + "/ksc";

  var init = () => {
    $(".btn.login").on("click", goToLogin);
    $(".btn.question").on("click", goToWrite);
    $(".logout").on("click", logout);
    $("button.signup").on("click", goToSignup);
    $("a.btn-signup").on("click", goToSignup);
    $("button.mypage").on("click", goToMyPage);

    $("#search-btn").on("click", e => {
      search(
        $(e.currentTarget)
          .closest("div.input-group")
          .find("input")
          .val()
      );
    });
  };

  var search = keywords => {
    location.href =
      BASE_URL + "/search?search=" + keywords + "&category=" + "all";
  };

  var goToLogin = () => {
    location.href = BASE_URL + "/login";
  };

  var goToMyPage = () => {
    location.href = BASE_URL + "/my";
  };

  var logout = e => {
    location.href = BASE_URL + "/public/logout.php";
  };

  var goToSignup = () => {
    location.href = BASE_URL + "/signup";
  };

  var goToWrite = () => {
    location.href = BASE_URL + "/write";
  };

  return {
    init: init
  };
})();

export { AsideModule, CommonModule };
