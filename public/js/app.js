$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 3 }
        }
    });
    $(document).on("click", ".barberdates td:not(.disabled)", function() {
        var date = $(this).data('date');
        const $checkbox = $(`input[type="checkbox"][value="${date}"]`);
        if ($checkbox.is(':checked')) {
            $checkbox.prop('checked', false);
            $(this).removeClass("selected");
        } else {
            $checkbox.prop('checked', true);
            $(this).addClass("selected");
        }

        const form = document.getElementById('workingdays');
        const formData = new FormData(form);
        $.ajax({
            url: "/cms/ajax/workingdays",
            method: "POST",
            data: formData,
            processData: false, // REQUIRED for FormData
            contentType: false, // REQUIRED for FormData
            success: function (result) {
                $("#div1").html(result);
            }
        });
    });
    $(document).on("click", "#nextmonth, #previousmonth", function() {
        var select = $(this).data('month');
        var current = $(this).data('current');
        $.ajax({
            url: "/cms/ajax/monthselect",
            method: "POST",
            datatype: "json",
            data: {
                month: select,
                current: current
            },
            success: function (result) {
                $(".calendar").html(result);
            }
        });
    });
});
