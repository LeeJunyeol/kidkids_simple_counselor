var AdminModule = (function () {
    var BASE_URL = "http://localhost/ksc";
    var QUESTION_API_URL = BASE_URL + "/api/Question"

    // 등록/수정/삭제 판넬
    var questionInputTemplate = handlebarsHelper("#question-input-template");
    // var answerHeaderTemplate = handlebarsHelper("#answer-header-template");
    // var categoryHeaderTemplate = handlebarsHelper("#category-header-template");
    var userAdminTemplate = handlebarsHelper("#user-admin-template");

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
            hideUserAdmin();
            $("#wrapper").removeClass("hide");
            $("#useradmin").addClass("hide");
        })
        $("#menu>li:eq(1)").on("click", function(e){
            getAnswers(1);
            hideUserAdmin();
            $("#wrapper").removeClass("hide");
            $("#useradmin").addClass("hide");
        })
        $("#menu>li:eq(2)").on("click", function(e){
            getCategories(1);
            hideUserAdmin();
            $("#wrapper").removeClass("hide");
            $("#useradmin").addClass("hide");
        })
        $("#menu>li:eq(3)").on("click", function(e){
            getUserScores().then(drawUserTemplate).then(bindAdvancementEvents);
            $("#useradmin").removeClass("hide");
            $("#wrapper").addClass("hide");
        })

        $("table").on("click", "tr", function(e){
            var selectedData = $(e.currentTarget).data("obj");
            selectedData["content"] = $(e.currentTarget).find(".content").text();
            selectedData["createDate"] = new Date(selectedData["createDate"]).toISOString().slice(0,10);
            selectedData["modifyDate"] = new Date(selectedData["modifyDate"]).toISOString().slice(0,10);
            $(".form-control").each(function(i, v){
                var name = $(v).prop("name");
                $(v).val(this[name]);
            }.bind(selectedData));
        });
    }

    function bindAdvancementEvents() {
        $("#useradmin").on("click", ".advance", function (e){
            var user = $(e.currentTarget).closest("tr").data("user");
            user['user_type'] = "전문가";
            user['message'] = "승급되었습니다.";
            updateUserType(user);
        });
        $("#useradmin").on("click", ".demolition", function(e){ 
            var user = $(e.currentTarget).closest("tr").data("user");
            user['user_type'] = "일반";
            user['message'] = "강등되었습니다.";
            updateUserType(user);
        });
    }

    function updateUserType(user) {
        $.ajax("http://localhost/ksc/api/User", {
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify(user)
        }).then(function(){
            alert(user['message']);
            getUserScores().then(drawUserTemplate).then(bindAdvancementEvents);
            $("#useradmin").removeClass("hide");
            $("#wrapper").addClass("hide");
        })
    }

    function hideUserAdmin(){
        if($("#useradmin").hasClass("hide")){
            $("#useradmin").addClass("hide");
        }
    }

    function drawUserTemplate(res) {
        $("#useradmin").html(userAdminTemplate(res));
    }

    function getUserScores() {
        return $.ajax("http://localhost/ksc/api/Controllers/User.php", {
            type: 'GET',
            contentType: "application/json"
        }).then(function(res){
            var results = JSON.parse(res);
            results.forEach(function(user, i){
                var 승급가능 = 사용자가승급가능한지(user);
                if(승급가능 > 0){
                    user['ok'] = true;
                } else if (승급가능 < 0){
                    user['no'] = true;
                }
            });
            return results;
        })
    }

    function 사용자가승급가능한지(user) {
        if (parseInt(user['selection_percentage']) >= 60 
        && parseInt(user['myscore']) >= 100
        && user['user_type'] !== "전문가") {
            return 1;
        } else if ((parseInt(user['selection_percentage']) < 60 
        || parseInt(user['myscore']) < 100)
        && user['user_type'] === "전문가") {
            return -1;
        } else {
            return 0;
        }
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