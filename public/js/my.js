var MyModule = (function(){
    var init = () => {
        load();
    }

    var load = () => {
        $.ajax("http://localhost/ksc/api/My?all", {
            type: 'GET'
        }).then((res) => {
            res = JSON.parse(res);
            console.log(res);
        })
    }

    return {
        init
    }
})();

$(document).ready(function(){
    MyModule.init();
});