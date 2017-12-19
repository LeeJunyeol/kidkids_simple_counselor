var MyModule = (function(){
    // 템플릿들
    var recentQuestionTemplate = handlebarsHelper("#recent-question-template");
    var recentAnswerTemplate = handlebarsHelper("#recent-answer-template");
    var init = () => {
        load();
    }

    var load = () => {
        $.ajax("http://localhost/ksc/api/My?all", {
            type: 'GET'
        }).then((res) => {
            res = JSON.parse(res);
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