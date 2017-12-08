var QUESTION_URL = "http://localhost/ksc/api/Controllers/Question.php";

$(document).ready(function () {

    var questionTemplate = handlebarsHelper("#question-template");
    var answerTemplate = handlebarsHelper("#answer-template");
    var opinionTemplate = handlebarsHelper("#opinion-template");

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
            var answers = result['answers'];
            var opinions = result['opinions'];

            console.log(question);
            console.log(answers);

            $("div.question.container").html(questionTemplate(question));
            $("div.reply-box").html(answerTemplate(answers));
            $("div.opinion-list>ul").html(opinionTemplate(opinions));
        })
    }


    $("div.reply-box").on("click", ".btn.view-opinions", function (e) {
        var $replyContainer = $(this).closest(".reply-card.container");
        var answerId = $replyContainer.find(".reply-footer-group").data("id");
        $(this).text("의견 숨기기");
        $(this).hasClass("")

        $.ajax("http://localhost/ksc/api/Controllers/Opinion.php", {
            type: "GET",
            contentType: "application/json",
            data: {
                id: answerId
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            if(result['success']){
                var opinions = result['opinions'];
                $replyContainer.find("ul").html(opinionTemplate(opinions));
                $replyContainer.find("ul").removeClass("hide");
            }
        });
    });

});