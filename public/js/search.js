import { AsideModule, CommonModule } from './common';

var SearchModule = (() => {
    var BASE_URL = location.origin + "";
    var questionResultTemplate = handlebarsHelper("#question-result-template");
    var answerResultTemplate = handlebarsHelper("#answer-result-template");
    var authorResultTemplate = handlebarsHelper("#author-result-template");

    var init = () => {
        requestSearchResults();
    }

    var requestSearchResults = () => {
        $.ajax(BASE_URL + "/api/Search" + location.search, {
            type: "GET"
        }).then(function(res){
            res = JSON.parse(res);
            res['questionResult'].forEach(element => {
                element['content'] = element['content'].substring(0, 100) + "...";
            });
            res['answerResult'].forEach(element => {
                element['content'] = element['content'].substring(0, 100) + "...";
            });
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
    AsideModule.init();
    CommonModule.init();
    SearchModule.init();
})