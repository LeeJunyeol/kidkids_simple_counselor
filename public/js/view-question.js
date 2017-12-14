var API_BASE_URL = "http://localhost/ksc/api";
var QUESTION_URL = API_BASE_URL + "/Question/";
var MY_QUESTION_URL = API_BASE_URL + "/my/Question/";

$(document).ready(function () {
    var questionTemplate = handlebarsHelper("#question-template");
    var answerTemplate = handlebarsHelper("#answer-template");
    var opinionTemplate = handlebarsHelper("#opinion-template");
    var opinionItemTemplate = handlebarsHelper("#opinion-item-template");
    var questionId = parseInt(location.href.split("/").pop());
    var userId = $("#welcome").data("id") || "";

    var isClicked = false;
    var re = /\r\n|\r|\n/g; // textarea 엔터자를때 필요한거

    init();

    function init() {
        render();
        $("div.reply-box").on("click", "a.vote.up", function (e) {
            vote.call(this, 1, userId, $(this).closest(".reply-card").data("id"));
        });
        $("div.reply-box").on("click", "a.vote.down", function (e) {
            vote.call(this, -1, userId, $(this).closest(".reply-card").data("id"));
        });
        $("#question-container").on("click", ".view-opinions", viewOpinion);

        // 댓글 클릭 이벤트
        $("div.reply-box").on("click", ".btn.view-opinions", function (e) {
            var $replyContainer = $(this).closest(".reply-card.container");
            var answerId = $replyContainer.find(".reply-footer-group").data("id");
            $(this).text("의견 숨기기");
            $(this).hasClass("")

            $.ajax("http://localhost/ksc/api/Answer/" + answerId + "/Opinion", {
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
    }

    // 댓글 클릭 이벤트
    function viewOpinion(e) {
        if (!isClicked) {
            isClicked = true;

            $.ajax("http://localhost/ksc/api/Opinion", {
                type: "GET",
                data: {
                    question_id: questionId
                }
            }).then(function (res) {
                var result = JSON.parse(res);
                var data;
                if (result['success']) {
                    data = {
                        question_id: questionId,
                        opinions: result['opinions']
                    }
                } else {
                    data = {
                        question_id: questionId
                    }
                }
                $(this.delegateTarget).append(opinionTemplate(data)); //question-container
                $("a.close.opinions").on("click", function(e){
                    $(e.currentTarget).closest(".opinion-list").toggle("blind");
                });
            }.bind(e)).then(function () {
                $("form.question").on("click", "button[type='submit']", function (e) {
                    e.preventDefault();
                    var $form = $(e.delegateTarget);
                    var content = $form.find("input[name='content']").val();

                    $.ajax("http://localhost/ksc/api/Opinion", {
                        type: 'POST',
                        data: {
                            questionId,
                            content
                        }
                    }).then(function (res) {
                        var result = JSON.parse(res);
                        if (result['success']) {
                            alert("댓글이 등록되었습니다.");
                            $(this).append(opinionItemTemplate(result['myopinion']));
                        } else {
                            alert("댓글 등록에 실패하였습니다.");
                        }
                    }.bind($form.closest(".opinion-list").find("ul.opinion-list")));
                })
            });
        } else {
            $(e.delegateTarget).find("div.opinion-list").toggle("blind");
        }
    }

    // 답글 투표를 한다.
    function vote(score, userId, answerId) {
        if (userId === "") return alert("로그인이 필요합니다.");
        $.ajax(API_BASE_URL + "/Answer/" + answerId + "/vote", {
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify({
                score,
                userId,
                answerId
            })
        }).then(function (res) {
            var result = JSON.parse(res);
            var $targetEle = $(this).closest(".vote-group").find("h2.votesum>span.score");
            if (result["success"]) {
                var $targetEle = $(this).closest(".vote-group").find("h2.votesum>span.score");
                var currentScore = $targetEle.text();
                if (currentScore !== "") {
                    $targetEle.text(parseInt($targetEle.text()) + parseInt(score));
                } else {
                    $targetEle.text(parseInt(score));
                }
                if (parseInt(score) > 0) {
                    $(this).css("border-color", "blue");
                } else {
                    $(this).css("border-color", "red");
                }
            }
            alert(result["message"]);
        }.bind(this))
    }

    // 템플릿을 그린다.
    function render() {
        $.ajax(API_BASE_URL + "/Question/" + questionId, {
            type: "GET",
            contentType: "application/json"
        }).then(function (res) {
            var result = JSON.parse(res);
            var question = result['question'];
            var answers = result['answers'];
            var opinions = result['opinions'];

            question.tags = question.tags.split("/");
            answers.forEach(element => {
                element.height = element.content.split(re).length * 22;
            });
            
            $("div.question.container").removeClass("hide");
            $("div.question.container").html(questionTemplate(question));
            $("div.reply-box").html(answerTemplate(answers));
            $("div.opinion-list>ul").html(opinionTemplate(opinions));

            var questionContent = question.content;
            var answerContent = answers.content;
            $("div.question.container").find("textarea").height(questionContent.split(re).length * 22);

            if ($("div.question.container").find(".header-group").data("id") === userId) {
                $("div.question.container").find(".btn-group").removeClass("not-visible");
            }
            $(".vote-group").each(function (i, ele) {
                var $ele = $(ele);
                var myvote = $ele.data("value");
                if (myvote !== undefined) {
                    if (parseInt(myvote) > 0) {
                        $ele.find(".up").css("border-color", "blue");
                    } else {
                        $ele.find(".down").css("border-color", "red");
                    }
                }
            });
        });
    }

    // 수정/삭제 이벤트
    $("#question-container").on("click", ".delete", function (e) {
        console.log("삭제!");
        $.ajax(API_BASE_URL + "/my/Question/" + questionId, {
            type: "DELETE"
        }).then(function (res) {
            console.log(res);
            var result = JSON.parse(res);
            alert(result['messages']);

            location.href = "http://localhost/ksc/home";
        });
    });
    $("#question-container").on("click", ".edit", function (e) {
        location.href = "http://localhost/ksc/update/" + questionId;
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
                    user_id: userId
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


});