$(document).ready(function () {
    $(".btn.login").on("click", function () {
        $("#myLoginModal").modal();
    })

    $(".btn.question").on("click", function () {
        location.href = location.origin + "/ksc/write";
    })

    $(".category-box").on("click", ".category-item", function(e){
        var category = $(this).find("a").text();
        $.ajax("http://localhost/ksc/api/Question/getByCategory.php", {
            type: "GET",
            contentType: "application/json",
            data: {
                category,
                page: 1
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            console.log(result);
            // if(result['success']){
            //     var opinions = result['opinions'];
            //     $replyContainer.find("ul").html(opinionTemplate(opinions));
            //     $replyContainer.find("ul").removeClass("hide");
            // }
        });

    })
});