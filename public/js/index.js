import { AsideModule, CommonModule } from "./common";
import { HandlebarsHelper, Utils } from "./util";

var HomeModule = (() => {
  var BASE_URL = location.origin + "/ksc";

  var questionTemplate = HandlebarsHelper("#questions-template");
  var paginationTemplate = HandlebarsHelper("#pagination-template");

  var currentPageNum = 1;
  var lastPageNum = 1;

  var $pageNav = $("#pageNav");
  var categoryId = $("#rank-aside").data("category-id");
  var sortBy = "default";
  var isAsc = false;

  function init() {
    getQuestions(1, sortBy, categoryId);

    // 페이지 네비게이션 이벤트
    $pageNav
      .on("click", "li.previous", prevPage)
      .on("click", "li.next", nextPage)
      .on("click", "li.pageNum", moveToPageNum);

    // 제목 클릭하면 이동 이벤트
    $("div.board>ul.list-group").on("click", ".list-header a", function(e) {
      e.preventDefault();
      var questionId = $(this)
        .closest("li")
        .data("id");
      $.ajax(BASE_URL + "/api/Question/" + questionId, {
        type: "PUT",
        contentType: "application/json",
        data: JSON.stringify({
          view: parseInt(
            $(this)
              .closest("li.question")
              .find("span.view-cnt")
              .text()
          )
        })
      }).then(function(res) {
        $.redirect("question/" + questionId, {
          question_id: questionId
        });
      });
    });

    // 최신순 조회순
    $("#btn-order-box").on("click", ".btn-order", function(e) {
      e.preventDefault();
      if ($(this).hasClass("latest")) {
        sortBy = "latest";
      } else {
        sortBy = "cnt";
      }
      $(this).toggleClass("isasc");
      $(this).hasClass("isasc") ? (isAsc = true) : (isAsc = false);

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
    dataObj["page"] = page;
    dataObj["sortBy"] = sortBy;
    dataObj["isASC"] = isAsc;
    dataObj["limit"] = 5;
    if (categoryId !== 0) {
      dataObj["categoryId"] = categoryId;
    }
    $.ajax(BASE_URL + "/api/Controllers/Question.php", {
      type: "GET",
      contentType: "application/json",
      data: dataObj
    }).then(function(res) {
      var result = JSON.parse(res);
      var questions = result["questions"];

      for (var i = 0; i < questions.length; i++) {
        questions[i].modify_date = Utils.getFormatDate(
          questions[i].modify_date
        );
        questions[i].tags = questions[i].tags.split("/");
      }

      $("div.board > ul.list-group").html(questionTemplate(questions));

      var arr = [];
      for (
        lastPageNum = 0;
        lastPageNum < parseInt(result["count"]) / 5;
        lastPageNum++
      ) {
        arr.push(lastPageNum + 1);
      }
      $("ul.pagination").html(paginationTemplate(arr));
    });
  }
  return {
    init
  };
})();

$(document).ready(function() {
  AsideModule.init();
  CommonModule.init();
  HomeModule.init();
});
