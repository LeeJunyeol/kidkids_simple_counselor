var MyModule = (function(){
    // 템플릿들
    var expertTemplate = handlebarsHelper("#expert-template");
    var userTemplate = handlebarsHelper("#user-template");
    var recentQuestionTemplate = handlebarsHelper("#recent-question-template");
    var recentAnswerTemplate = handlebarsHelper("#recent-answer-template");
    var init = () => {
        load();
    }

    var load = () => {
        $.ajax("http://localhost/ksc/api/User/" + location.href.split("/").slice(-1), {
            type: 'GET'
        }).then((res) => {
            res = JSON.parse(res);
            
            var user = res['user'];
            var recentQuestions = res['recentQuestion'];
            var recentAnswers = res['recentAnswer'];

            recentQuestions.forEach(element => {
                element['create_date'] = Utils.getFormatDate(element['create_date']);
                element['link'] = "http://localhost/ksc/question/" + element['question_id']; 
            });
            recentAnswers.forEach(element => {
                element['create_date'] = Utils.getFormatDate(element['create_date']);
                element['link'] = "http://localhost/ksc/question/" + element['question_id'];
            });

            var scorePer = user['score'] / 500 * 100;
            user['userlevel'] = Math.floor(scorePer / 100);
            user['scorePer'] = scorePer - user['userlevel'] * 100;

            $("#profile-box>.box").append(expertTemplate(user));
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