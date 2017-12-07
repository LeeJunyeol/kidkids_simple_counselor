$(document).ready(function () {
    $(".btn.login").on("click", function () {
        $("#myLoginModal").modal();
    })

    $(".btn.question").on("click", function () {
        location.href = "write";
    })
});