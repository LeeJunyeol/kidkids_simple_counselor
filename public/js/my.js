import { AsideModule, CommonModule } from './common';

$(document).ready(function(){
    CommonModule.init();
    MyModule.init();
});

var MyModule = (function(){
    var BASE_URL = location.origin + "/ksc";
    var userId = $("#welcome").data("id");

    // 템플릿들
    var recentQuestionTemplate = handlebarsHelper("#recent-question-template");
    var recentAnswerTemplate = handlebarsHelper("#recent-answer-template");
    var currentRankTemplate = handlebarsHelper("#current-rank-template");

    var init = () => {
        load();
    }

    var load = () => {
        $.ajax(BASE_URL + "/api/My?all", {
            type: 'GET'
        }).then((res) => {
            res = JSON.parse(res);
            var recentQuestions = res['recentQuestion'],
                recentAnswers = res['recentAnswer'],
                currentRank = res['currentRank'];

            var myIdx = 0;
            
            currentRank.forEach((element, i) => {
                if (element['user_id'] === userId) {
                    myIdx = i;
                }
                element['rank'] = ++i;
            });
            // 내 위치가 0~4 일때
            // 0~4 모두 출력
            if (myIdx >= 0 && myIdx <= 4) {
                currentRank = currentRank.slice(0, 5);
            } else {
                currentRank = currentRank.slice(myIdx - 4, myIdx + 1);
            }

            recentQuestions.forEach(element => {
                element['content'] = element['content'].substring(0, 100) + "...";
                element['create_date'] = Utils.getFormatDate(element['create_date']);
                element['link'] = "/question/" + element['question_id'];
            });
            recentAnswers.forEach(element => {
                element['content'] = element['content'].substring(0, 100) + "...";
                element['create_date'] = Utils.getFormatDate(element['create_date']);
                element['link'] = "/question/" + element['question_id'];
            });
            $("#question-box").append(recentQuestionTemplate(recentQuestions));
            $("#answer-box").append(recentAnswerTemplate(recentAnswers));
            $("#rank-box>.box").html(currentRankTemplate(currentRank));
        })
    }

    return {
        init
    }
})();

<<<<<<< HEAD
$(document).ready(function () {
    MyModule.init();
});
=======
>>>>>>> 77420720a99ec5964857328b9f23c8f8606679de
