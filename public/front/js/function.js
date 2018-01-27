$(function () {
    function incrementValue(e, ele) {
        var class_t = ele.attr('data-type');
        var valueElement = $('.' + class_t);
        var num = isNaN(parseInt(valueElement.val())) ? 0 : parseInt(valueElement.val());
        valueElement.val(Math.max(num + e.data.increment, 0));
        valueElement.keyup();
        return false;
    }

    $(document).on('click', '.plus', {increment: 1}, function (r) {
        incrementValue(r, $(this));
    });
    $(document).on('click', '.minus', {increment: -1}, function (r) {
        incrementValue(r, $(this));
    });
});
$(document).ready(function () {
    $(function () {

    });
});

$(document).ready(function () {
    // $(".js-example-basic-multiple").select2({
    //   placeholder: "الرجاء الاختيار",
    //   dir: "rtl"
    // });
});


$(document).ready(function () {
    $('.irs-from').on('DOMSubtreeModified', function () {
        var number = $(this).text();
        $('#form').val(number);
    });
});

$(document).ready(function () {
    $(".menu-sidebar li:has(ul)").click(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });
});

$(document).ready(function () {
    $(".btn-menu").click(function () {
        $(".menu-side").css({'left': '0'});
        $(".btn-menu-close").css({'left': '0px'});
        $(".btn-menu").css({'display': 'none'});
        $(".back-menu").css({'display': 'block'});
    });
});

$(".bg_get_some_add").click(function () {
    $('.get_some_add').hide();
});

$(".close_get_some_add").click(function () {
    $('.get_some_add').hide();
});

$(".bg_get_some_error3").click(function () {
    $('.get_some_error3').hide();
});
$(".close_get_some3").click(function () {
    $('.get_some_error3').hide();
});
$("#active_phone").click(function () {
    $('.get_some_error3').show();
});

$("#get-chash").click(function () {
    $('.get_some_error').show();
    $('.no-js').addClass('pop');
});
$(".bg_get_some_error").click(function () {
    $('.get_some_error').hide();
    $('.no-js').removeClass('pop');
});
$(".close_get_some").click(function () {
    $('.get_some_error').hide();
    $('.no-js').removeClass('pop');
});

$("#put-chash").click(function () {
    $('.get_some_error2').show();
    $('.no-js').addClass('pop');
});
$(".bg_get_some_error2").click(function () {
    $('.get_some_error2').hide();
    $('.no-js').removeClass('pop');
});
$(".close_get_some2").click(function () {
    $('.get_some_error2').hide();
    $('.no-js').removeClass('pop');
});

$("#get-chash").click(function () {
    $('.get_some_error').show();
});
$(".bg_get_some_error").click(function () {
    $('.get_some_error').hide();
});
$(".close_get_some").click(function () {
    $('.get_some_error').hide();
});


$(".bg_nofication_error").click(function () {
    $('.nofication_error').hide();
});
$(".bg_nofication").click(function () {
    $('.nofication_good').hide();
});

$(".bg_some_error").click(function () {
    $('.nofication_error').hide();
});
$(".close_good").click(function () {
    $('.nofication_good').hide();
});
$(".close_error").click(function () {
    $('.nofication_error').hide();
});
$(".nofication_error_item").click(function () {
    $('.nofication_error').hide();
});

$(".close_some").click(function () {
    $('.some_error').hide();
});
$(".bg_some_error").click(function () {
    $('.some_error').hide();
});
$("#tabelg").click(function () {
    $('.some_error').show();
});

$("#fofaret").click(function () {
    $('.nofication_good').show();
    setTimeout(function () {
        $(".nofication_good").hide();
    }, 2500);
});

$(".btnmenu").click(function () {
    $(".body").addClass('active');
    $(".no-js").addClass('active');
    $(".menu_sidebar").addClass('active');
    $(".body_bg").css({'display': 'block'});
});

$(".body_bg").click(function () {
    $(".menu_sidebar").removeClass('active');
    $(".body").removeClass('active');
    $(".no-js").removeClass('active');
    $(".colse").css({'display': 'none'});
    $(".body_bg").css({'display': 'none'});
    $(".btnmenu").css({'display': 'block'});
});
$(".btn-menu").click(function () {
    $(".menu-side").css({'left': '0'});
    $(".btn-menu-close").css({'left': '0px'});
    $(".btn-menu").css({'display': 'none'});
    $(".back-menu").css({'display': 'block'});
});
function closeMenu() {
    $(".menu-side").css({'left': '-350px'});
    $(".btn-menu-close").css({'left': '-10px'});
    $(".btn-menu").css({'display': 'block'});
    $(".back-menu").css({'display': 'none'});
}
$(".btn-menu-close").click(function () {
    closeMenu();
});
$(".back-menu").click(function () {
    closeMenu();
});

$(".menu-sidebar li:not(.nohide)").click(function () {
    $(this).children('.submen').toggle("fast", function () {
    });
    closeMenu();
});
$(".menu-sidebar li.nohide").click(function () {
    $(this).children('.submen').toggle("fast", function () {
    });
});
