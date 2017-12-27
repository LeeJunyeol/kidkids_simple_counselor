var ViewModule = (() => {
    var answerViewTemplate = handlebarsHelper("#answer-view-template");
<<<<<<< HEAD
    var BASE_URL = location.origin;
=======
    var BASE_URL = location.origin + "";
>>>>>>> a2710d18fa48c2655c6e27b1234972924ab93ae5

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