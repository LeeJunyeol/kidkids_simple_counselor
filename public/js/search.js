var SearchModule = (() => {
    var questionResultTemplate = handlebarsHelper("#question-result-template");
    var answerResultTemplate = handlebarsHelper("#answer-result-template");
    var authorResultTemplate = handlebarsHelper("#author-result-template");

    var init = () => {
        requestSearchResults();
    }

    var requestSearchResults = () => {
        $.ajax("http://localhost/ksc/api/Search" + location.search, {
            type: "GET"
        }).then(function(res){
            res = JSON.parse(res);
            $(".body.question").html(questionResultTemplate(res['questionResult']));
            $(".body.answer").html(answerResultTemplate(res['answerResult']));
            $(".body.author").html(authorResultTemplate(res['authorResult']));
        })
    }

    return {
        init
    }
})();

$(document).ready(function(){
    SearchModule.init();
})