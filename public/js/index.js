var API_BASE_URL = "http://localhost/ksc/api";
var QUESTION_URL = API_BASE_URL + "/Question/";
var MY_QUESTION_URL = API_BASE_URL + "/my/Question/";

$(document).ready(function () {
    var url = "";

    var questionTemplateScript = $("#questions-template").html();
    var questionTemplate = Handlebars.compile(questionTemplateScript);

    var paginationTemplateScript = $("#pagination-template").html();
    var paginationTemplate = Handlebars.compile(paginationTemplateScript);

    var currentPageNum = 1;
    var lastPageNum = 1;

    var category = $("div.title>h2").text();
    var sortBy = "default";
    var isAsc = false;

    init();

    function init() {
        if (category === "전체 질문") {
            category = undefined; // -> 공백 ""
        }
        getQuestions(1, sortBy, category);

        // 페이지 네비게이션 이벤트
        $("#pageNav").on("click", "li.previous", prevPage);
        $("#pageNav").on("click", "li.next", nextPage);
        $("#pageNav").on("click", "li.pageNum", moveToPageNum);

        // 제목 클릭하면 이동 이벤트
        $("div.board>ul.list-group").on("click", ".list-header a", function (e) {
            e.preventDefault();
            var questionId = $(this).closest("li").data("id");
            $.ajax(API_BASE_URL + "/Question/" + questionId, {
                type: "PUT",
                contentType: "application/json",
                data: JSON.stringify({
                    view: parseInt($(this).closest("li.question").find("span.view-cnt").text())
                })
            }).then(function (res) {
                $.redirect("question/" + questionId, {
                    "question_id": questionId
                });
            })
        })

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

            getQuestions(currentPageNum, sortBy, category);
        })
    }

    function prevPage(e){
        if (currentPageNum > 1) {
            currentPageNum--;
            getQuestions(currentPageNum, sortBy, category);
        } else {
            alert("첫 페이지입니다.");
        }
    }

    function nextPage(e){
        if (currentPageNum < lastPageNum) {
            currentPageNum++;
            getQuestions(currentPageNum, sortBy, category);
        } else {
            alert("마지막 페이지입니다.");
        }
    }

    function moveToPageNum(e){
        currentPageNum = parseInt($(e.currentTarget).data("num"));
        getQuestions(currentPageNum, sortBy, category);
    }

    // 질문 목록을 불러온다.
    function getQuestions(page, sortBy, category) {
        var dataObj = {};
        dataObj['page'] = page;
        dataObj['sortBy'] = sortBy;
        dataObj['isASC'] = isAsc;
        dataObj['limit'] = 5;
        if (category !== undefined) {
            dataObj['category'] = category;
        }
        $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
            type: "GET",
            contentType: "application/json",
            data: dataObj
        }).then(function (res) {
//            console.log(res);
            var result = JSON.parse(res);
            var questions = result['questions'];
            
            for (var i = 0; i < questions.length; i++) {
                questions[i].modify_date = getFormatDate(questions[i].modify_date);
                questions[i].tags = questions[i].tags.split("/");
            }

            $("div.board > ul.list-group").html(questionTemplate(questions));

            var arr = [];

            for (lastPageNum = 0; lastPageNum < parseInt(result['count']) / 5; lastPageNum++) {
                arr.push(lastPageNum + 1);
            }

            $("ul.pagination").html(paginationTemplate(arr));
        })
    }

    var WEEK_DAYS = ["일", "월", "화", "수", "목", "금", "토"];

    function getFormatDate(inputDate) {
        var date = new Date(inputDate);

        return date.getFullYear() + "." +
            (date.getMonth() + 1) + "." +
            date.getDate() + "." + "(" + WEEK_DAYS[new Date(inputDate).getDay()] + ")";
    }


});