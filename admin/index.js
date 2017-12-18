var AdminModule = (function () {
    var BASE_URL = "http://localhost/ksc";
    var QUESTION_API_URL = BASE_URL + "/api/Question"

    // 등록/수정/삭제 판넬
    var questionInputTemplate = handlebarsHelper("#question-input-template");
    // var answerHeaderTemplate = handlebarsHelper("#answer-header-template");
    // var categoryHeaderTemplate = handlebarsHelper("#category-header-template");

    // 테이블 헤더 템플릿
    var questionHeaderTemplate = handlebarsHelper("#question-header-template");
    var answerHeaderTemplate = handlebarsHelper("#answer-header-template");
    var categoryHeaderTemplate = handlebarsHelper("#category-header-template");
    
    // 템플릿
    var questionTemplate = handlebarsHelper("#question-template");
    var answerTemplate = handlebarsHelper("#answer-template");
//    var categoryTemplate = handlebarsHelper("#category-template");
    
    function init() {
        getQuestions(1);
        $("#menu>li:eq(0)").on("click", function(e){
            getQuestions(1);
        })
        $("#menu>li:eq(1)").on("click", function(e){
            getAnswers(1);
        })
        $("#menu>li:eq(2)").on("click", function(e){
            getCategories(1);
        })

    }

    function getCategories() {
        $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
            type: 'GET',
            contentType: "application/json",
            data: dataObj
        }).then(function(res){
            var results = JSON.parse(res);
            console.log(results);
            // $("#form").html(questionInputTemplate());
            $("thead").html(questionHeaderTemplate());
            $("tbody").html(questionTemplate(results['questions']));
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
            $("#form").html(questionInputTemplate());
            $("thead").html(questionHeaderTemplate());
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
            $("thead").html(answerHeaderTemplate());
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