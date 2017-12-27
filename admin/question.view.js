var ViewModule = (() => {
    var questionViewTemplate = handlebarsHelper("#question-view-template");
    var BASE_URL = location.origin + "";

    var init = () => {
        load();
    }

    var load = () => {
        $.ajax(BASE_URL + "/api/Question/" + location.href.split("/").pop(), {
            type: "GET"
        }).then(function(res){
            var res = JSON.parse(res);
            var question = res['question'];
            $("#form").html(questionViewTemplate(question));
        })
    }
    
    return {
        init
    }
})();

$(document).ready(() => {
    ViewModule.init();
});