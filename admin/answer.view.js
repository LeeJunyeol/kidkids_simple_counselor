var ViewModule = (() => {
    var answerViewTemplate = handlebarsHelper("#answer-view-template");
    var BASE_URL = location.origin + "/ksc";

    var init = () => {
        load();
    }

    var load = () => {
        $.ajax(BASE_URL + "/api/Answer/" + location.href.split("/").pop(), {
            type: "GET"
        }).then(function(res){
            var res = JSON.parse(res);
            var answer = res['answer'];
            $("#form").html(answerViewTemplate(answer));
        })
    }
    
    return {
        init
    }
})();

$(document).ready(() => {
    ViewModule.init();
});