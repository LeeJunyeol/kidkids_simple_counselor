var API_BASE_URL = "http://localhost/ksc/api";
var QUESTION_URL = API_BASE_URL + "/Question/";
var MY_QUESTION_URL = API_BASE_URL + "/my/Question/";

$(document).ready(function () {
    var questionTemplate = handlebarsHelper("#question-template");
    var answerTemplate = handlebarsHelper("#answer-template");
    var opinionTemplate = handlebarsHelper("#opinion-template");
    var questionId = parseInt(location.href.split("/").pop());
    var userId =  $("#welcome").data("id") || "";

    init();

    function init() {
        render();
        $("div.reply-box").on("click", "span.vote.up", function(e){
            vote.call(this, 1, userId, $(this).closest(".reply-card").data("id"));
        });
        $("div.reply-box").on("click", "span.vote.down", function(e){
            vote.call(this, -1, userId, $(this).closest(".reply-card").data("id"));
        });
    }

    // 답글 투표를 한다.
    function vote(score, userId, answerId) {
        if(userId === "") return alert("로그인이 필요합니다.");
        $.ajax(API_BASE_URL + "/Answer/" + answerId + "/vote", {
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify({score, userId, answerId})
        }).then(function(res){
            var result = JSON.parse(res);
            if(result["success"]){
                $targetEle = $(this).closest(".reply-title-group").find("h3.reply>span.label");
                $targetEle.text(parseInt($targetEle.text()) + score);
            }
            alert(result["message"]);
        }.bind(this))
    }

    // 템플릿을 그린다.
    function render(){
        $.ajax(API_BASE_URL + "/Question/" + questionId, {
            type: "GET",
            contentType: "application/json"
        }).then(function (res) {
            var result = JSON.parse(res);
            var question = result['question'];
            var answers = result['answers'];
            var opinions = result['opinions'];
            
            $("div.question.container").removeClass("hide");
            $("div.question.container").html(questionTemplate(question));
            $("div.reply-box").html(answerTemplate(answers));
            $("div.opinion-list>ul").html(opinionTemplate(opinions));
            
            if($("div.question.container").find(".header-group").data("id") === userId){
                $("div.question.container").find(".btn-group").removeClass("not-visible");
            }
        })
    }

    // 수정/삭제 이벤트
    $("#question-container").on("click", ".delete", function(e){
        console.log("삭제!");
        $.ajax(API_BASE_URL + "/my/Question/" + questionId, {
            type: "DELETE"
        }).then(function(res){
            console.log(res);
            var result = JSON.parse(res);
            alert(result['messages']);

            location.href="http://localhost/ksc/home";
        });
    });
    $("#question-container").on("click", ".edit", function(e){
        location.href="http://localhost/ksc/update/" + questionId;
    });

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
                    question_id: questionId,
                    user_id: "tipa"
                }
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            if (result['success']) {
                var insertedAnswer = result['data'];
                $("div.reply-box").append(answerTemplate([insertedAnswer]));
                $("#write-box").toggle("blind");
                $("button.btn.reply").toggleClass("btn-danger").text("답글달기");
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
        if (!$(this).hasClass("btn-danger")) {
            $(this).text("취소");
        } else {
            $(this).text("답글달기");
        }
        $(this).toggleClass("btn-danger");

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