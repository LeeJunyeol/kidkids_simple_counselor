$(document).ready(function () {
    var rankBodyTemplate = handlebarsHelper("#rank-body-template");

    $(".btn.login").on("click", function () {
        $("#myLoginModal").modal();
    })
    $(".btn.question").on("click", goToWrite);
    $(".category-box").on("click", ".category-item>div>a", goToHomeByCategory);
    $(".logout").on("click", logout);
    $("button.signup").on("click", goToSignup);
    $("a.btn-signup").on("click", goToSignup);

    renderRankBox();
    
    function renderRankBox(){
        $.ajax("http://localhost/ksc/api/Rank", {
            type: 'GET',
            data: {
                ranker: true
            }
        }).then(function(res){
            var result = JSON.parse(res);
            var rankers = result['ranker'];
            rankers.map(function(v, i){
                v['rank'] = ++i;
            })
            $("#rank-body").html(rankBodyTemplate(rankers));
        })
    }
    

    // function login(e) {
    //     e.preventDefault();
    //     var id = $("#usrname").val();
    //     var password = $("#psw").val();
    //     console.log(id);
    //     console.log(password);
    //     $.ajax("http://localhost/ksc/api/User?login", {
    //         type: 'POST',
    //         data: {
    //             id, password
    //         }
    //     })
    // }

    function logout(e) {
        location.href = "http://localhost/ksc/public/logout.php";
    }

    function goToSignup() {
        location.href = location.origin + "/ksc/signup";
    }

    function goToWrite() {
        location.href = location.origin + "/ksc/write";
    }

    function goToHomeByCategory(e) {
        var category = $(this).text();
        location.href = "http://localhost/ksc/home?category=" + category;
    }
});