var MyModule = (function(){
    var BASE_URL = location.origin + "/ksc";

    // 템플릿들
    var expertTemplate = handlebarsHelper("#expert-template");
    var userTemplate = handlebarsHelper("#user-template");
    var recentQuestionTemplate = handlebarsHelper("#recent-question-template");
    var recentAnswerTemplate = handlebarsHelper("#recent-answer-template");
    var init = () => {
        load();
    }

    var load = () => {
        $.ajax(BASE_URL + "/api/User/" + location.href.split("/").slice(-1), {
            type: 'GET'
        }).then((res) => {
            res = JSON.parse(res);
            
            var user = res['user'];
            var recentQuestions = res['recentQuestion'];
            var recentAnswers = res['recentAnswer'];

            recentQuestions.forEach(element => {
                element['content'] = element['content'].substring(0, 100) + "...";
                element['create_date'] = Utils.getFormatDate(element['create_date']);
                element['link'] = "/ksc/question/" + element['question_id']; 
            });
            recentAnswers.forEach(element => {
                element['content'] = element['content'].substring(0, 100) + "...";
                element['create_date'] = Utils.getFormatDate(element['create_date']);
                element['link'] = "/ksc/question/" + element['question_id'];
            });

            var scorePer = user['score'] / 500 * 100;
            user['userlevel'] = Math.floor(scorePer / 100);
            user['scorePer'] = scorePer - user['userlevel'] * 100;

            if(user['user_type'] === '전문가'){
                $("#profile-box>.box").append(expertTemplate(user));
            }
            $("#profile-box>.box").append(userTemplate(user));
            $("#question-box").append(recentQuestionTemplate(recentQuestions));
            $("#answer-box").append(recentAnswerTemplate(recentAnswers));
        })
    }

    return {
        init
    }
})();

$(document).ready(function(){
    MyModule.init();
});