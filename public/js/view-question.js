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
            e.preventDefault();
            vote.call(this, 1, userId, $(this).closest(".reply-card").data("id"));
        });
        $("div.reply-box").on("click", "a.vote.down", function (e) {
            e.preventDefault();
            vote.call(this, -1, userId, $(this).closest(".reply-card").data("id"));
        });
        $("#question-container").on("click", ".view-opinions", viewOpinion);
        // 댓글 클릭 이벤트
        $("div.reply-box").on("click", ".btn.view-opinions", viewOpinionOnAnswer);
    }

    function viewOpinionOnAnswer(e){
        if (!isClicked) {
            var answerId = $(e.currentTarget).closest(".reply-footer-group").data("id");
            isClicked = true;

            $.ajax("http://localhost/ksc/api/Opinion", {
                type: "GET",
                data: {
                    answer_id: answerId
                }
            }).then(function (res) {
                var result = JSON.parse(res);
                var data;
                if (result['success']) {
                    data = {
                        answer_id: answerId,
                        opinions: result['opinions']
                    }
                } else {
                    data = {
                        answer_id: answerId,
                    }
                }
                $(e.currentTarget).closest(".reply-card.container").append(opinionTemplate(data));
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
                            answerId,
                            content
                        }
                    }).then(function (res) {
                        var result = JSON.parse(res);
                        if (result['success']) {
                            alert("댓글이 등록되었습니다.");
                            $(this).append(opinionItemTemplate(result['myopinion']));
                            $(this).removeClass("hide");
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
                            $(this).removeClass("hide");
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
            //$("span.score").closest(".reply-card.container").position()
            if (result["success"]) {
                var $targetEle = $(this).closest(".vote-group").find("h2.votesum>span.score");
                var currentScore = $targetEle.text();
                currentScore = parseInt($targetEle.text()) + parseInt(score);
                if (currentScore !== "") {
                    currentScore = parseInt($targetEle.text()) + parseInt(score);
                } else {
                    currentScore = parseInt(score);
                }
                $targetEle.text(currentScore);
                if (parseInt(score) > 0) {
                    $(this).css("border-color", "blue");
                } else {
                    $(this).css("border-color", "red");
                }
                var $currentContainer = $(this).closest(".reply-card.container");
                $currentContainer.data("score", currentScore);

                var movingContainers = $(".reply-card.container").filter(function(index){
                    if($(this).data("id") !== $currentContainer.data("id") && $(this).data("score") <= currentScore && $(this).offset().top < $currentContainer.offset().top){
                        var $target = $(this);
                        $(this).animate({"top": "+=209"}, "slow");
                        return this;
                    }
                });
                console.log(movingContainers);
                var targetPosition = $(movingContainers).offset();
                console.log($currentContainer.offset(targetPosition));
            }
            alert(result["message"]);
        }.bind(this))
    }

    function rearrangeWhenVote(){

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
            $("div.question.container").find("textarea").height(questionContent.split(re).length * 28);

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