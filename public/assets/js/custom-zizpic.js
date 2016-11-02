$('.not-space').on({
    keydown: function(e) {
        if (e.which === 32)
            return false;
    },
    change: function() {
        this.value = this.value.replace(/\s/g, "");
    }
});


var x;
var phone;

$("form").bind("keypress", function(e) {
    if (e.keyCode == 13) {
        return false;
    }
});

if ($('input[type="radio"]').is(":checked")) {
    // alert($("form input[type='radio']:checked").val());
    if ($("form input[type='radio']:checked").val() == 1) {

        $('.zizpic_2').hide();
        $('.zizpic_3').hide();
        $('.zizpic_1').css('float', 'none');
        $('.zizpic_1').removeClass('col-sm-4');
        $('.zizpic_1').addClass('bdr0 zizpic_1');
        $('.zizpic_1_0').addClass('upImg zizpic_1_0 col-sm-6 col-sm-offset-3 bdr0');
        $('#zizpic_1').val(package_1);
        $('#zizpic_3').val(package_3);
        $('#zizpic_shipment').val(shipment);

        var total = parseInt(package_1);// + shipment);
        $('#amount').val(total);
        $('.price').html(package_1 + currency);

        if (total > 0)
        {
            $('.total_amount').html(total + currency);
        } else {
            $('.total_amount').html(free);
        }

    }
    if ($("form input[type='radio']:checked").val() == 3) {

        $('.price').html(package_3 + currency);
        $('#zizpic_1').val(package_1);
        $('#zizpic_3').val(package_3);

        $('#zizpic_shipment').val(shipment);
        var total = parseInt(package_3);// + shipment);
        $('.total_amount').html(total + currency);
        $('#amount').val(total);
        if (total > 0)
        {
            $('.total_amount').html(total + currency);
        } else {
            $('.total_amount').html(free);
        }
    }
}
$('.coupon').on('click', function(e) {

    e.preventDefault();
    var code = $('input[name="coupon_code"]').val();
    var package = '';
    if ($('input[type="radio"]').is(":checked")) {

        package = $('input[type="radio"]:checked').val();
    }
    $('.coupon-msg').html('');
    if (code == '')
    {
        $('.coupon-msg').html(invalid_coupon);
    }

    $.ajax({
        url: baseURL + '/zizpicorders/coupon/?package=' + package + '&code=' + code,
        type: "get",
        success: function(response) {
            console.log(response);
            var json = JSON.parse(response);

            if (json.status == 0)
            {
                $('.coupon-msg').html(invalid_coupon);
                //  $('#by_phone').removeAttr('class', 'by_phone').addClass('form-control btn default');
            }
            else
            {
                $('.codeInputSec').css('width', 'auto');
                $('input[name="zizcode"]').val(json.status);
                var amount = parseInt($('#amount').val()) - parseFloat(json.amount);
                $('#amount').val(parseFloat(amount).toFixed(2));
                if (amount <= 0)
                {
                    x = $('#pay_option').detach();
                    $('#by-phone').show();
                    $('span#zc_discount').html(gift);
                    $('.total_amount').css('color', 'red').html(free);
                    $('.phone_order_lebel').hide();
                    $('.leave_phn_num').hide();
                    phone = $('.phone_order').detach();
                    $('center h4').detach();
                } else
                {
                    if (language == "en") {
                        $('.total_amount').css('color', 'red').html(amount + currency);
                        $('span#zc_discount').html('- ' + parseFloat(json.amount) + currency);
                    } else
                    {
                        $('.total_amount').css('color', 'red').html(+amount + currency);
                        $('span#zc_discount').html('-' + parseFloat(json.amount) + currency);
                    }
                }


                $('.zc').show();
                $('input[name="coupon_code"]').before('<p style="font-size: 16px;margin: 11px 0 10px;" id="coupon_error" class="coupon_error">' + code + '</p>');
                $('#coupon_submit').hide();
                $('input[name="coupon_code"]').hide();

            }
        }
    });
});


$('#by_paypal_payment').on('click', function(e) {

    e.preventDefault();
    var error = 0;

    var total_window_ht = $('body').height();

    $('input[type=text]').each(function() {
        $(this).removeClass('error');
        var txt_val = $(this).val().trim();
        var txt_name = $(this).attr('name');

        if (txt_name == 'name' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'email' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }

        if (txt_name == 'full_name' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'phone' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }

        if (txt_name == 'address' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'city' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'zip' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'country' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }

    });
    var package = '';
    if ($('input[type="radio"]').is(":checked")) {

        package = $('input[type="radio"]:checked').val();
    }
    var zizpic_1_image = $('input[name="zizpic_1_image"]').val();
    var zizpic_2_image = $('input[name="zizpic_2_image"]').val();
    var zizpic_3_image = $('input[name="zizpic_3_image"]').val();

    if (package == 1) {
        if (zizpic_1_image == '')
        {
            $('.zizpic_error_1').show();
            $('.zizpic_error_1').css('display', 'block');

            var height_from_top = $('input[name="zizpic_1_image"]').offset().top;
            var ht_to_scroll = (total_window_ht - height_from_top) + 100;

            $('html, body').animate({
                scrollTop: '-=' + ht_to_scroll
            }, 1000);
            return false;

        }
    }
    if (package == 3) {
        var is_img_uploaded = 0;
        if (zizpic_1_image == '')
        {
            $('.zizpic_error_1').show();
            $('.zizpic_error_1').css('display', 'block');
            is_img_uploaded++;

        }
        if (zizpic_2_image == '')
        {
            $('.zizpic_error_2').show();
            $('.zizpic_error_2').css('display', 'block');
            is_img_uploaded++;
        }
        if (zizpic_3_image == '')
        {
            $('.zizpic_error_3').show();
            $('.zizpic_error_3').css('display', 'block');
            is_img_uploaded++;
        }

        if (is_img_uploaded > 0)
        {
            var height_from_top = $('input[name="zizpic_1_image"]').offset().top;
            var ht_to_scroll = (total_window_ht - height_from_top) + 100;

            $('html, body').animate({
                scrollTop: '-=' + ht_to_scroll
            }, 1000);
            return false;
        }

    }
    var email = $('input[name="email"]').val();
    var emailReg = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

    if (!emailReg.test(email))
    {
        $('input[name="email"]').addClass('error').show();
        error++;
    }
    if (error > 0)
    {
        var height_from_top = $('input[name="coupon_code"]').offset().top;
        var ht_to_scroll = (total_window_ht - height_from_top) + 250;

        $('html, body').animate({
            scrollTop: '-=' + ht_to_scroll
        }, 1000);
        return false;
    }
    error = 0;
    var code = $('input[name="coupon_code"]').val();
    var package = '';
    if ($('input[type="radio"]').is(":checked")) {

        package = $('input[type="radio"]:checked').val();
    }
    $('.coupon-msg').html('');


    $.ajax({
        url: baseURL + '/zizpicorders/coupon/?package=' + package + '&code=' + code,
        type: "get",
        success: function(response) {
            var json = JSON.parse(response);

            var zizpic_1_image = $('input[name="zizpic_1_image"]').val();
            var zizpic_2_image = $('input[name="zizpic_2_image"]').val();
            var zizpic_3_image = $('input[name="zizpic_3_image"]').val();

            var checkImg = 0;
            if (package == 1) {
                if (zizpic_1_image == '')
                {
                    $('.zizpic_error_1').show();
                    checkImg++;
                    return false;
                }
            }
            if (package == 3) {
                if (zizpic_1_image == '')
                {
                    $('.zizpic_error_1').show();
                    $('.zizpic_error_1').css('display', 'block');
                    checkImg++;
                }
                if (zizpic_2_image == '')
                {
                    $('.zizpic_error_2').show();
                    $('.zizpic_error_2').css('display', 'block');
                    checkImg++;
                }
                if (zizpic_3_image == '')
                {
                    $('.zizpic_error_3').show();
                    $('.zizpic_error_3').css('display', 'block');
                    checkImg++;
                }
            }
            if (checkImg == 0) {
                $('#zizpic_order_form').submit();
            }
        }

    });

});

$('#by_phone').on('click', function() {


    $('#by-phone').show();
    $('#payment_method').val('phone');
    $('.phone_order').attr('required', 'required');
    //$("body").animate(window.scrollBy(0, 100));
    //$("body").animate({"scrollTop": window.scrollY - 300}, 1000);
    $('html, body').animate({
        scrollTop: '+=150'
    }, 1000);

});

$('.by-paypal').on('click', function() {
    $('.phone_order').removeAttr('required');

    $('#by-phone').slideUp("2000").animate();
    $('#payment_method').val('paypal');
});

$('input[name="zizpackage"]').on('click', function(event) {

    $("#pay_option_menu").prepend(x);
    $('.zc').hide();
    $('.codeInputSec').removeAttr('style');
    $('.coupon_error').css('display', 'none');
    $('#coupon_submit').show();
    $('input[name="coupon_code"]').val("");
    $('.coupon-msg').html("");
    var zizpic_1 = $('#zizpic_1').val();
    var zizpic_3 = $('#zizpic_3').val();
    var shipment = $('#zizpic_shipment').val();

    if ($(this).val() == 1) {

        $('#zizpic_item').html(1);
        var total = parseInt(zizpic_1);// + parseInt(shipment);
        $('.zizpic_2').hide();
        $('.zizpic_3').hide();
        $('.price').html(zizpic_1 + currency);
        $('input[name="coupon_code"]').show();
        $('.phone_order_lebel, .leave_phn_num').show();
        $('.phone_order_append').prepend(phone);
        $('.zizpic_1').css('float', 'none');
        $(".zizpic_1").removeClass("col-sm-4 zizpic_1").addClass("bdr0 zizpic_1");
        $('.zizpic_1_0').addClass('col-sm-6 col-sm-offset-3 bdr0');

        $('.total_amount').html(total + currency);
        $('#amount').val(total);


    }
    if ($(this).val() == 3) {
        $('#zizpic_item').html(3);
        $('.upImg').removeClass('col-sm-6 col-sm-offset-3 bdr0');
        // window.location.href = "";
        $(".zizpic_1").addClass("col-sm-4 col-ziz zizpic_1").removeClass("col-sm-6 col-ziz2 col-md-push-1 ");
        $('.phone_order_append').prepend(phone);
        $('#coupon_submit').show();
        $('input[name="coupon_code"]').show();
        $('#coupon_error').detach();
        $('.coupon_id').before($('input[name="coupon_code"]').detach());
        var total = parseInt(zizpic_3);// + parseInt(shipment);
        if (language == "en") {

            $('.zizpic_1').css('float', 'left');
            $('.price').html(zizpic_3 + currency);
            $('.total_amount').html(total + currency);
        } else
        {
            $('.zizpic_1').css('float', 'right');

            $('.price').html(zizpic_3 + currency);
            $('.total_amount').html(total + currency);
        }
        $('.zizpic_2').show();
        $('.zizpic_3').show();

        $('#amount').val(total);
    }
});


$('#form_submit').on('click', function(e) {
    e.preventDefault();
    var total_window_ht = $('body').height();


    var error = 0;

    $('input[type=text]').each(function() {
        $(this).removeClass('error');

        var txt_val = $(this).val().trim();
        var txt_name = $(this).attr('name');

        if (txt_name == 'name' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'email' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }

        if (txt_name == 'full_name' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'phone' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'phone_order' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'address' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'city' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'zip' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }
        if (txt_name == 'country' && txt_val == "")
        {
            $(this).addClass('error');
            error++;
        }


    });
    var email = $('input[name="email"]').val();
    var emailReg = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

    if (!emailReg.test(email))
    {
        $('input[name="email"]').addClass('error').show();
        error++;
    }
    var package = '';
    if ($('input[type="radio"]').is(":checked")) {

        package = $('input[type="radio"]:checked').val();
    }

    var zizpic_1_image = $('input[name="zizpic_1_image"]').val();
    var zizpic_2_image = $('input[name="zizpic_2_image"]').val();
    var zizpic_3_image = $('input[name="zizpic_3_image"]').val();

    if (package == 1) {
        if (zizpic_1_image == '')
        {
            $('.zizpic_error_1').show();
            $('.zizpic_error_1').css('display', 'block');
            var height_from_top = $('input[name="zizpic_1_image"]').offset().top;
            var ht_to_scroll = (total_window_ht - height_from_top) + 100;

            $('html, body').animate({
                scrollTop: '-=' + ht_to_scroll
            }, 1000);
        }
    }
    if (package == 3) {
        if (zizpic_1_image == '')
        {
            $('.zizpic_error_1').show();
            $('.zizpic_error_1').css('display', 'block');
            var height_from_top = $('input[name="zizpic_1_image"]').offset().top;
            var ht_to_scroll = (total_window_ht - height_from_top) + 100;

            $('html, body').animate({
                scrollTop: '-=' + ht_to_scroll
            }, 1000);
        }
        if (zizpic_2_image == '')
        {
            $('.zizpic_error_2').show();
            $('.zizpic_error_2').css('display', 'block');
            var height_from_top = $('input[name="zizpic_1_image"]').offset().top;
            var ht_to_scroll = (total_window_ht - height_from_top) + 100;

            $('html, body').animate({
                scrollTop: '-=' + ht_to_scroll
            }, 1000);
        }
        if (zizpic_3_image == '')
        {
            $('.zizpic_error_3').show();
            $('.zizpic_error_3').css('display', 'block');
            var height_from_top = $('input[name="zizpic_1_image"]').offset().top;
            var ht_to_scroll = (total_window_ht - height_from_top) + 100;

            $('html, body').animate({
                scrollTop: '-=' + ht_to_scroll
            }, 1000);
        }
    }
    if (error > 0)
    {
        var height_from_top = $('input[name="coupon_code"]').offset().top;
        var ht_to_scroll = (total_window_ht - height_from_top) + 250;

        $('html, body').animate({
            scrollTop: '-=' + ht_to_scroll
        }, 1000);
        return false;
    }

    var code = $('input[name="coupon_code"]').val();

    $('.coupon-msg').html('');


    $.ajax({
        url: baseURL + '/zizpicorders/coupon/?package=' + package + '&code=' + code,
        type: "get",
        success: function(response) {
            console.log(response);
            var json = JSON.parse(response);

            var zizpic_1_image = $('input[name="zizpic_1_image"]').val();
            var zizpic_2_image = $('input[name="zizpic_2_image"]').val();
            var zizpic_3_image = $('input[name="zizpic_3_image"]').val();

            var checkImg = 0;
            if (package == 1) {
                if (zizpic_1_image == '')
                {
                    $('.zizpic_1 .image-wrapper zizpic_1_error .error').show();
                    checkImg++;
                    return false;
                }
            }
            if (package == 3) {
                if (zizpic_1_image == '')
                {
                    $('.zizpic_1 .image-wrapper .error').show();
                    checkImg++;
                }
                if (zizpic_2_image == '')
                {
                    $('.zizpic_2 .image-wrapper .error').show();
                    checkImg++;
                }
                if (zizpic_3_image == '')
                {
                    $('.zizpic_3 .image-wrapper .error').show();
                    checkImg++;
                }

            }
            if (checkImg == 0) {
                $('#zizpic_order_form').submit();
            }

        }
    });

});

$('.image-wrapper img').hide();
function changeStatus(status, id) {

    bootbox.confirm('Are you sure want to change transaction status ?', function(statusOk)
    {
        if (statusOk)
        {
            $.ajax({
                url: baseURL + '/zizpic/changeOrderStatus/?status=' + status + '&id=' + id,
                type: "get",
                success: function(response) {
                    console.log(response);
                    $('td#status').html(response);

                    bootbox.alert('Status successfully ' + response + ' !');
                }
            });
        }
    });

}

// Image preive on change

function getImg(input, id)
{
    if (input.files && input.files[0]) {
        console.log(/^image/.test(input.files[0].type));
        console.log(input.files[0].type);
        if (/^image/.test(input.files[0].type)) {
            var filerdr = new FileReader();
            filerdr.onload = function(e) {
                $('#zizpic_img_' + id).addClass('zizpic_img');
                $('#zizpic_img_' + id).attr('src', e.target.result).show();
                $('.fileUploadImg-zizpic_img_' + id).show();
            }
            var data = filerdr.readAsDataURL(input.files[0]);
        } else
        {
            $('.fileUploadImg-zizpic_img_' + id).hide();
            $('.zizpic_error_' + id).html('Upload valid image type').show();
        }
    }
}


function updateZizpicPrice() {

    var current_price = $('#amount').val();
    $.ajax({
        url: baseURL + '/zizpic/zizpicorders/?current_price=' + current_price,
        type: "get",
        success: function(response) {
            // console.log(response);
        }
    });
} 