var QUESTION_URL = "http://localhost/ksc/api/Controllers/Question.php";

$(document).ready(function () {

    var questionTemplate = handlebarsHelper("#question-template");
    var answerTemplate = handlebarsHelper("#answer-template");
    var opinionTemplate = handlebarsHelper("#opinion-template");
    var id;


    init();

    function init() {
        id = parseInt($("article").data("id"));

        $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
            type: "GET",
            contentType: "application/json",
            data: {
                id
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            var question = result['question'];
            var answers = result['answers'];
            var opinions = result['opinions'];

            $("div.question.container").removeClass("hide");
            $("div.question.container").html(questionTemplate(question));
            $("div.reply-box").html(answerTemplate(answers));
            $("div.opinion-list>ul").html(opinionTemplate(opinions));
        })
    }

    // 답글등록 이벤트
    $("#btn-post-reply").on("click", function (e) {
        var title = $("div.write.header>textarea").val();
        var content = $("div.write.content>textarea").val();

        $.ajax("http://localhost/ksc/api/Controllers/Answer.php", {
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            data: {
                answer: {
                    title,
                    content,
                    question_id: id,
                    user_id: "tipa"
                }
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            if (result['success']) {
                var insertedAnswer = result['data'];
                $("div.reply-box").append(answerTemplate([insertedAnswer]));
                $("#write-box").toggle("blind");
                alert("답변이 등록되었습니다!");
            } else {
                alert("등록이 실패하였습니다.");
            }
            if (JSON.parse(res)) {

            }
        }, function (res) {
            console.log("서버 오류");
        });
    });

    // 답글달기 버튼 이벤트
    $("#question-container").on("click", "button.btn.reply", function (e) {
        if (!$(this).hasClass("cancel")) {
            $(this).text("취소");
        } else {
            $(this).text("답글달기");
        }
        $(this).toggleClass("cancel");

        $("#write-box").toggle("blind");
    })

    // 의견남기기 버튼 이벤트
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
            if (result['success']) {
                var opinions = result['opinions'];
                $replyContainer.find("ul").html(opinionTemplate(opinions));
                $replyContainer.find("ul").removeClass("hide");
            }
        });
    });

});