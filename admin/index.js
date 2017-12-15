var AdminModule = (function () {
    var BASE_URL = "http://localhost/ksc";
    var QUESTION_API_URL = BASE_URL + "/api/Question"

    // 템플릿
    var questionTemplate = handlebarsHelper("#question-template");
    var answerTemplate = handlebarsHelper("#answer-template");

    function init() {
        getQuestions(1);
        $("#menu>li:eq(0)").on("click", function(e){
            getQuestions(1);
        })
        $("#menu>li:eq(1)").on("click", function(e){
            getAnswers(1);
        })

    }

    function getQuestions(page) {
        var dataObj = {};
        dataObj['page'] = page;
        dataObj['sortBy'] = "id";
        dataObj['isASC'] = "true";
        dataObj['limit'] = 20;

        $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
            type: 'GET',
            contentType: "application/json",
            data: dataObj
        }).then(function(res){
            var results = JSON.parse(res);
            console.log(results);
            $("tbody").html(questionTemplate(results['questions']));
        })
    }

    function getAnswers(page) {
        var dataObj = {};
        dataObj['page'] = page;
        dataObj['limit'] = 20;

        $.ajax("http://localhost/ksc/api/Controllers/Answer.php", {
            type: 'GET',
            contentType: "application/json",
            data: dataObj
        }).then(function(res){
            var results = JSON.parse(res);
            console.log(results);
            $("tbody").html(answerTemplate(results['answers']));
        })
    }

    return {
        init
    }
})();

$(document).ready(function () {
    AdminModule.init();
})