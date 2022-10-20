$(document).ready(function () {
    $(".add-to-cart").on("click", function () {
        var dataId = $(this).attr("data-id");
        var dataName = $(this).attr("data-name");
        var dataImage = $(this).attr("data-img");
        var dataPrice = $(this).attr("data-price");
        var dataAction = $(this).attr("data-action");
        console.log(dataAction);
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                product_id: dataId,
                product_name: dataName,
                product_price: dataPrice,
                product_image: dataImage,
                action: dataAction
            },
            success: function (data) {
                $('table #mytable1').html(data);
                location.reload();
            }
        });
    });
});
