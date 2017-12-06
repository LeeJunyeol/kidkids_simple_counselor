$(document).ready(function () {
    var url = "";
    $.ajax("http://localhost/ksc/api/Controllers/Question.php", {
        type: "GET",
        contentType: "application/json"
    }).then(function(res){
        console.log(res);
    })
});