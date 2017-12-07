var QUESTION_URL = "http://localhost/ksc/api/Controllers/Question.php";

$(document).ready(function () {
    var questionTemplateScript = $("#question-template").html();
    var questionTemplate = Handlebars.compile(questionTemplateScript);

    init();

    function init() {
        $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
            type: "GET",
            contentType: "application/json",
            data: {
                id: 1
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            var question = result['question'];

            $("div.question.container").html(questionTemplate(question));
            // $("div.board > ul.list-group").html(questionTemplate(result['data']));

            // var arr = [];

            // for (lastPageNum = 0; lastPageNum <= parseInt(result['count']) / 5; lastPageNum++) {
            //     arr.push(lastPageNum + 1);
            // }

            // $("ul.pagination").html(paginationTemplate(arr));
        })
    }

});