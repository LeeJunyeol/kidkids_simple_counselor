var QUESTION_URL = "http://localhost/ksc/api/Controllers/Question.php";

$(document).ready(function () {
    var url = "";

    var questionTemplateScript = $("#questions-template").html();
    var questionTemplate = Handlebars.compile(questionTemplateScript);

    var paginationTemplateScript = $("#pagination-template").html();
    var paginationTemplate = Handlebars.compile(paginationTemplateScript);

    var currentPageNum = 1;
    var lastPageNum = 1;

    init();

    function init() {
        getQuestions(1);

        $("#pageNav").on("click", "li.previous", function (e) {
            if (currentPageNum > 1) {
                currentPageNum--;
                getQuestions(currentPageNum);
            } else {
                alert("첫 페이지입니다.");
            }
        })
        $("#pageNav").on("click", "li.next", function (e) {
            if (currentPageNum < lastPageNum) {
                currentPageNum++;
                getQuestions(currentPageNum);
            } else {
                alert("마지막 페이지입니다.");
            }
        })
        $("#pageNav").on("click", "li.pageNum", function (e) {
            currentPageNum = parseInt($(e.currentTarget).data("num"));
            getQuestions(currentPageNum);
        })

        $("div.board>ul.list-group").on("click", "")
    }

    function getQuestions(page) {
        $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
            type: "GET",
            contentType: "application/json",
            data: {
                page: page
            }
        }).then(function (res) {
            var result = JSON.parse(res);

            $("div.board > ul.list-group").html(questionTemplate(result['data']));

            var arr = [];

            for (lastPageNum = 0; lastPageNum <= parseInt(result['count']) / 5; lastPageNum++) {
                arr.push(lastPageNum + 1);
            }

            $("ul.pagination").html(paginationTemplate(arr));
        })
    }
});