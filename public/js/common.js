$(document).ready(function () {
    $(".btn.login").on("click", function () {
        $("#myLoginModal").modal();
    })
    $(".btn.question").on("click", goToWrite);
    $(".category-box").on("click", ".category-item>div>a", goToHomeByCategory);

    function goToWrite() {
        location.href = location.origin + "/ksc/write";
    }

    function goToHomeByCategory(e) {
        var category = $(this).text();
        location.href = "http://localhost/ksc/home?category=" + category;
    }
});