var QUESTION_URL = "http://localhost/ksc/api/Controllers/Question.php";

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
        if(category === "전체 질문"){
            category = undefined;
        }
        getQuestions(1, sortBy, category);
        
        $("#pageNav").on("click", "li.previous", function (e) {
            if (currentPageNum > 1) {
                currentPageNum--;
                getQuestions(currentPageNum, sortBy, category);
            } else {
                alert("첫 페이지입니다.");
            }
        })
        $("#pageNav").on("click", "li.next", function (e) {
            if (currentPageNum < lastPageNum) {
                currentPageNum++;
                getQuestions(currentPageNum, sortBy, category);
            } else {
                alert("마지막 페이지입니다.");
            }
        })
        $("#pageNav").on("click", "li.pageNum", function (e) {
            currentPageNum = parseInt($(e.currentTarget).data("num"));
            getQuestions(currentPageNum, sortBy, category);
        })

        $("div.board>ul.list-group").on("click", "li.question>p>a", function (e) {
            e.preventDefault();
            var questionId = $(this).closest("li").data("id");
            $.redirect("question/" + questionId, {
                "question_id": questionId
            });
        })

        // 최신순 조회순
        $("#btn-order-box").on("click", ".btn-order", function (e) {
            e.preventDefault();
            if($(this).hasClass("latest")){
                sortBy = "latest";
            } else {
                sortBy = "cnt";
            }
            $(this).toggleClass("isasc");
            $(this).hasClass("isasc")? isAsc = true : isAsc = false;

            getQuestions(currentPageNum, sortBy, category);

            // var questionId = $(this).closest("li").data("id");
            // $.redirect("question/" + questionId, {
            //     "question_id": questionId
            // });
        })
    }

    function getQuestions(page, sortBy, category) {
        var dataObj = {};
        dataObj['page'] = page;
        dataObj['sortBy'] = sortBy;
        dataObj['isASC'] = isAsc;
        if(category !== undefined){
            dataObj['category'] = category;
        }
        $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
            type: "GET",
            contentType: "application/json",
            data: dataObj
        }).then(function (res) {
            var result = JSON.parse(res);

            $("div.board > ul.list-group").html(questionTemplate(result['data']));

            var arr = [];

            for (lastPageNum = 0; lastPageNum < parseInt(result['count']) / 5; lastPageNum++) {
                arr.push(lastPageNum + 1);
            }

            $("ul.pagination").html(paginationTemplate(arr));
        })
    }
});