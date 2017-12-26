"use strict";

var ViewModule = function () {
    var BASE_URL = location.origin + "/ksc";
    var API_BASE_URL = "/ksc/api";
    var QUESTION_URL = API_BASE_URL + "/Question/";
    var MY_QUESTION_URL = API_BASE_URL + "/my/Question/";

    var questionTemplate = handlebarsHelper("#question-template");
    var answerTemplate = handlebarsHelper("#answer-template");
    var opinionTemplate = handlebarsHelper("#opinion-template");
    var opinionAnswerTemplate = handlebarsHelper("#opinion-answer-template");
    var opinionItemTemplate = handlebarsHelper("#opinion-item-template");

    var questionId = parseInt(location.href.split("/").pop());
    var userId = $("#welcome").data("id") || "";

    var re = /\r\n|\r|\n/g; // textarea 엔터자를때 필요한거

    var selected = false;

    // 투표 버튼 클릭이벤트 바인딩
    function bindVoteBtnClickEvents() {
        $("div.reply-box").on("click", "a.vote.up", function (e) {
            e.preventDefault();
            vote.call(this, 1, userId, $(this).closest(".reply-card").data("id"));
        });
        $("div.reply-box").on("click", "a.vote.down", function (e) {
            e.preventDefault();
            vote.call(this, -1, userId, $(this).closest(".reply-card").data("id"));
        });
    }

    // 답글 보여주기 클릭이벤트 바인딩(답글 보여주기) 
    function bindViewOpinionsClickEvents() {
        $("#question-container").on("click", ".view-opinions", function (e) {
            $(e.currentTarget).closest("#question-container").find("div.opinion-list").toggleClass("hide");
        });
        $("div.reply-box").on("click", ".btn.view-opinions", function (e) {
            $(e.currentTarget).closest(".reply-card.container").find("div.opinion-list").toggleClass("hide");
        });
    }

    // 답글달기 버튼 클릭했을 때, 답글 등록할 때 이벤트
    function bindReplyEvents() {
        $("#question-container").on("click", "button.btn.reply", function (e) {
            if (userId === "") return alert("로그인이 필요합니다.");
            if (!$(this).hasClass("btn-danger")) {
                $(this).text("취소");
            } else {
                $(this).text("답글달기");
            }
            $(this).toggleClass("btn-danger");

            $("#write-box").toggle("blind");
        });

        // 답글등록 이벤트
        $("#btn-post-reply").on("click", function (e) {
            if (userId === "") return alert("로그인이 필요합니다.");
            var title = $("div.write.header>textarea").val();
            var content = $("div.write.content>textarea").val();

            $.ajax(BASE_URL + "/api/Controllers/Answer.php", {
                type: "POST",
                contentType: "application/x-www-form-urlencoded",
                data: {
                    answer: {
                        title: title,
                        content: content,
                        question_id: questionId,
                        user_id: userId
                    }
                }
            }).then(function (res) {
                var result = JSON.parse(res);
                if (result['success']) {
                    var insertedAnswer = result['data'];
                    $("div.reply-box").append(answerTemplate([insertedAnswer]));
                    $("div.reply-box>.reply-card:last-child").append(opinionAnswerTemplate());
                    $("div.reply-box>.reply-card:last-child").find("textarea").height(insertedAnswer['content'].split(re).length * 21);
                    $("#write-box").toggle("blind");
                    $("button.btn.reply").toggleClass("btn-danger").text("답글달기");
                    $("div.reply-card.container").each(function (i, v) {
                        var $spanSpecial = $(v).find("span.user-type");
                        if ($spanSpecial.text() === "전문가") {
                            $spanSpecial.addClass("special");
                            $spanSpecial.closest("div.page-header").find(".img-div").removeClass("hide");
                        }
                    });
                    alert("답변이 등록되었습니다!");
                } else {
                    alert("등록이 실패하였습니다.");
                }
            }, function (res) {});
        });
    }

    function init() {
        render();

        bindVoteBtnClickEvents();
        bindViewOpinionsClickEvents();
        bindReplyEvents();

        $("div.reply-box").on("click", ".select-btn", function (e) {
            if (!selected) {
                if (confirm("채택 하시겠습니까?(한 번 채택하시면 수정할 수 없습니다)")) {
                    $(e.currentTarget).addClass("selected");
                    var answerId = $(e.currentTarget).closest(".reply-card").data("id");
                    selected = true;
                    $(".reply-box").find(".select-btn:not(.selected)").hide();
                    $(e.currentTarget).closest(".reply-card").find("span").removeClass("hide");
                    $.ajax(BASE_URL + "/api/Answer/" + answerId, {
                        type: "PUT",
                        contentType: "application/json",
                        data: JSON.stringify({
                            selection: true,
                            questionId: questionId
                        })
                    }).then(function (res) {
                        alert("채택이 완료되었습니다.");
                    });
                }
            }
        });

        $("div.reply-box").on("click", ".delete", function (e) {
            if (confirm("답변을 삭제하시겠습니까?")) {
                var $currentContainer = $(e.currentTarget).closest(".reply-card");
                var answerId = $currentContainer.data("id");
                $.ajax(BASE_URL + "/api/Answer/" + answerId, {
                    type: 'DELETE'
                }).then(function (res) {
                    res = JSON.parse(res);
                    alert(res['message']);
                    this.remove();
                }.bind($currentContainer));
            }
        });

        // 수정/삭제 이벤트
        $("#question-container").on("click", ".delete", function (e) {
            $.ajax(API_BASE_URL + "/my/Question/" + questionId, {
                type: "DELETE"
            }).then(function (res) {
                var result = JSON.parse(res);
                alert(result['messages']);

                location.href = BASE_URL + "/home";
            });
        });
        $("#question-container").on("click", ".edit", function (e) {
            location.href = BASE_URL + "/update/" + questionId;
        });
    }

    // 템플릿을 그린다.
    function render() {
        $.ajax(API_BASE_URL + "/Question/" + questionId, {
            type: "GET",
            contentType: "application/json"
        }).then(function (res) {
            // 템플릿을 그린다.(각종 효과 추가)
            var result = JSON.parse(res);
            var question = result['question'];
            var answers = result['answers'];
            var questionsOpinions = {};
            questionsOpinions.question_id = question.question_id;
            questionsOpinions.opinions = result['questionOpinions'];
            var answerOpinions = result['answerOpinions'];

            // 댓글 옆에 댓글 숫자 추가
            question.opinion_cnt = questionsOpinions.opinions.length;
            answers.forEach(function (v, i) {
                if (answerOpinions[parseInt(v.answer_id)]) {
                    v.opinion_cnt = answerOpinions[parseInt(v.answer_id)].length;
                } else {
                    v.opinion_cnt = 0;
                }
            });

            question.tags = question.tags.split("/");
            answers.forEach(function (element) {
                element.height = element.content.split(re).length * 21;
            });

            $("div.question.container").removeClass("hide");

            // 템플릿 그린다.
            $("div.question.container").data("id", question.question_id);
            $("div.question.container").html(questionTemplate(question));
            $("div.question.container").append(opinionTemplate(questionsOpinions));
            $("div.reply-box").html(answerTemplate(answers));
            $("div.reply-card.container").each(function (i, ele) {
                if ($(ele).data("selection") === 1) {
                    $(ele).addClass("selected-answer");
                    $(ele).find(".select-btn").removeClass("hide");
                    $(ele).find(".select-btn").addClass("selected");
                    $(ele).find(".selection-text").removeClass("hide");
                }
                $(ele).append(opinionAnswerTemplate(answerOpinions[$(ele).data("id")]));
            });

            var questionContent = question.content;
            var answerContent = answers.content;
            $("div.question.container").find("textarea").height(questionContent.split(re).length * 21);

            $("div.reply-card.container").each(function (i, v) {
                var $spanSpecial = $(v).find("span.user-type");
                if ($spanSpecial.text() === "전문가") {
                    $spanSpecial.addClass("special");
                    $spanSpecial.closest("div.page-header").find("div.img-div").removeClass("hide");
                }
            });

            // 수정/삭제 버튼 표시
            if ($("div.question.container").find(".header-group").data("id") === userId) {
                $("div.question.container").find(".btn-group").removeClass("not-visible");
                if (parseInt(question['selected_answer_id']) === 0) {
                    $(".select-btn").removeClass("hide");
                }
            }

            $("div.reply-box").find("span.answer-author").each(function (i, v) {
                if ($(v).text() !== userId) {
                    $(v).closest(".reply-card.container").find(".edit-btn-group").addClass("not-visible");
                }
            });

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
        }).then(function () {
            $("div.opinion-list").on("click", "button[type='submit']", function (e) {
                if (userId === "") return alert("로그인이 필요합니다.");
                e.preventDefault();

                var $form = $(e.delegateTarget).find("form");
                var id = $form.closest(".container").data("id");
                var content = $form.find("input[name='content']").val();
                var data = {
                    content: content
                };
                if ($form.hasClass("question")) {
                    data.questionId = id;
                } else {
                    data.questionId = location.href.split("/").pop();
                    data.answerId = id;
                }

                $.ajax("/ksc/api/Opinion", {
                    type: 'POST',
                    data: data
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
            });
        });;
    }

    // 답글 투표를 한다.
    function vote(score, userId, answerId) {
        if (userId === "") return alert("로그인이 필요합니다.");
        $.ajax(API_BASE_URL + "/Answer/" + answerId + "/vote", {
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify({
                score: score,
                userId: userId,
                answerId: answerId
            })
        }).then(function (res) {
            var result = JSON.parse(res);
            if (result["success"]) {
                var currentVote = parseInt($(this).find("span").text().trim());
                $(this).find("span").text(++currentVote);
                if ($(this).hasClass("up")) {
                    $(this).css("border-color", "blue");
                } else {
                    $(this).css("border-color", "red");
                }
            }
            window.alert(result["message"]);
        }.bind(this));
    }

    return {
        init: init
    };
}();

$(document).ready(function () {
    ViewModule.init();
});