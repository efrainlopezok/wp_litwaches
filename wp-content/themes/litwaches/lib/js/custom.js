var variation_color = undefined;

jQuery(document).ready(function ($) {

    // mobile hamburger
    $('.hamburger-right').click(function (e) {
        e.preventDefault();
        console.log('hamb');
        var exp = this.getAttribute('aria-expanded');

        if (exp == undefined || exp === "false") {
            $(this).attr('aria-expanded', 'true');
            $('.top-menu-center').attr('aria-expanded', 'true');
        } else {
            $(this).attr('aria-expanded', 'false');
            $('.top-menu-center').attr('aria-expanded', 'false');
        }
    });

    /* Product Change image */
    $('.phoen_uuyrre .product-option-div.phoen_radio input[name="style"]').on('click', function () {
        var current_image = $(this).parent().find('img').attr('src');
        $('.single-product .content-sidebar-wrap').css('background-image', 'url(' + current_image + ')');
        $('.single-product .woocommerce-product-gallery .flex-control-nav li img').removeClass('flex-active');
        $('.single-product .woocommerce-product-gallery .flex-control-nav li:nth-child(1) img').addClass('flex-active');
        $('.single-product .woocommerce-product-gallery .flex-control-nav li:nth-child(1) img').attr('src', current_image);
    });
    /* End Product Change image */

    // Home wach slider
    if ($('.home-wach-slider').length > 0) {
        $('.home-wach-slider').slick({
            centerMode: true,
            dots: true,
            infinite: true,
            slidesToShow: 1,
            centerPadding: '28%',
            dotsClass: 'slick-dots c-slick-dots',
            responsive: [{
                    breakpoint: 991,
                    settings: {
                        centerPadding: '10%',
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        centerPadding: '0',
                    }
                }
            ]
        });
    }

    if ($('.testimonial-slider').length > 0) {
        $('.testimonial-slider').slick({
            arrows: false,
            centerMode: false,
            centerPadding: '0',
            dots: true,
            infinite: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            dotsClass: 'slick-dots c-slick-dots',
            responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                },
            ]
        });
    }

    // closing modals
    if ($('.c-modal .close').length > 0) {
        $('.c-modal .close').click(function (e) {
            if ($(e.target).closest('.modal-content').length > 0) {
                $(e.target).closest('.video-modal').find('.video-wrapper').empty();
                $(e.target).closest('.c-modal').removeClass('show');
            }
        });
    }

    // Single product image as background
    if ($('.single-product .woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image').length > 0) {
        if ($('.single-product .woocommerce-product-gallery__wrapper img').length > 0) {
            var imgUrl = $('.single-product .woocommerce-product-gallery__wrapper img').attr('src');
            $('.content-sidebar-wrap').css('background-image', 'url(' + imgUrl + ')');
        }
    } else {
        if ($('.single-product .woocommerce-product-gallery__wrapper img').length > 0) {
            var imgUrl = $('.single-product .woocommerce-product-gallery__wrapper img').attr('src').split('-600x');
            var imgExt = imgUrl[1].split('.');
            $('.content-sidebar-wrap').css('background-image', 'url(' + imgUrl[0] + '.' + imgExt[1] + ')');
        }
    }
    $('.woocommerce-product-gallery .flex-control-thumbs li img').live('click', function () {
        var imgcUrl = $(this).attr('src').split('-100x');
        var imgcExt = imgcUrl[1].split('.');
        $('.content-sidebar-wrap').css('background-image', 'url(' + imgcUrl[0] + '.' + imgcExt[1] + ')');
    });

    // disabled by default add-to-cart
    if ($('.single_add_to_cart_button').length) {
        setTimeout(function () {
            $('.single_add_to_cart_button').attr('disabled', 1);
        }, 350);
    }

    // Adding markup popup wrap for Strap color selector
    if ($('.single-product .product-option-div').length > 1) {
        var attrWrap = $('div.phoen_uuyrt').last(),
            attrCnt = attrWrap.closest('.product-option-div'),
            labelTitle = attrCnt.prev().html(),
            topCnt = attrCnt.parent();

        // create trigger select
        var html = '<div class="variation-selector variation-select-image variation-select-disabled">';
        html += '<select id="pa_strap-color" class="" name="attribute_pa_strap-color" data-attribute_name="attribute_pa_strap-color" data-show_option_none="yes">';
        html += '<option value="">Choose an option</option>';
        html += '<option value="" class="attached enabled"></option>';
        html += '</select>';
        html += '</div>';
        topCnt.append(html);

        // create popup
        attrCnt.wrap('<div class="popup-body"></div>');
        attrCnt.parent().prepend('<h3 class="popup-title">Select a ' + labelTitle + '</h3>');
        attrCnt.parent().prepend('<div class="popup-close"></div>');
        attrCnt.parent().wrap('<div class="variation-popup"></div>');

        $('.variation-popup .popup-body').append('<p class="btn-clr">CHOOSE COLOR</p>');

        $('.variation-popup .popup-body').on('click', 'p.btn-clr', function(e){
            e.preventDefault();
            // $(this).parent().find('input').trigger('click');
            variation_color = $('.custom_options_select_color:checked').val();
            $('.variation-popup .popup-close').trigger('click');
        });

        // add variation pricing elements
        // var newPriceHtml = '<ins>';
        // newPriceHtml += '<span class="woocommerce-Price-amount amount"></span>';
        // newPriceHtml += '</ins>';
        // $('.woocommerce div.product p.price >span').wrap('<del></del>');
        // $('.woocommerce div.product p.price').append(newPriceHtml);

        // open variation popup
        $('.variation-select-disabled').click(function () {
            if ($('input[type="radio"][name="style"]:checked').length > 0) {
                $(this).closest('.phoen_uuyrre').find('.variation-popup').addClass('show');
                variation_color = $('.custom_options_select_color:checked').val();
            }
        });

        // close variation popup when click outside or when choose a variation swatch option
        $('.variation-popup').click(function (e) {
            if ($(e.target).closest('.popup-body').length == 0 || $(e.target).closest('.swatch').length > 0) {
                $(e.target).closest('.variation-popup').removeClass('show');
                fireCloseColorPopup();
            }
        });

        // close variation popup when click outside or when choose a variation swatch option
        $('.popup-close').click(function (e) {
            $('.variation-popup').removeClass('show');
            fireCloseColorPopup();
        });

        // choice a color
        $('.custom_options_select_color').change(function () {
            if ($(this).is(':checked')) {
                var value = $(this).val();
                if (value) {
                    $('#pa_strap-color option:eq(1)').text(value);
                    $('#pa_strap-color option:eq(1)').val(value);
                    $('#pa_strap-color').prop('selectedIndex', 1);
                }
                else {
                    $('#pa_strap-color').prop('selectedIndex', 0);
                }
            }
        });

        // when a variation is choosed, update price
        $('.custom_options_select_color, .custom_options_style').change(function () {
            setTimeout(function () {
                var amount = $('#product-options-total .amount').html();
                $('.woocommerce div.product p.price ins .amount, .woocommerce div.product p.price >.amount').html(amount);
            }, 350);
        });
    }

    // Single-product: Custom styles options selection
    if( $('.single-product input.custom_options_style').length > 0 ) {

        $('input.custom_options_style').each(function(idx, el) {
            var value = $(el).val();
            if(value) {
                $(el).parent().attr('title', value);
            }
        });

        // Change Style title text when a Style is selected
        $('input.custom_options_style').change(function(e) {
            if( $(this).is(':checked') ) {
                var value = $(this).val();
                $(this).closest('.phoen_uuyrre').find('>h3.phoen_normal_yyt > span').html(value);
            }
        });
    }

    // Enabling add to cart button
    if( $('.single-product').length > 0 ) {
        $('input.custom_options_style, input.custom_options_select_color').change(function() {
            var style_selected = $('input.custom_options_style:checked').length > 0,
                color_selected = $('input.custom_options_select_color:checked').length > 0;

            if( !style_selected || !color_selected ) {
                setTimeout(function () {
                    $('.single_add_to_cart_button').attr('disabled', 1);
                }, 350);
            }
        });
    }

    // Woo commerce plus/minus buttons

    $(document).on('click', '.woo-plus-btn, .woo-minus-btn', function () {
        var parent = $(this).closest('.quantity');
        if (parent.length == 0) {
            return;
        }

        var input = parent.find('input'),
            curValue = parseInt(input.val());

        if ($(this).hasClass('woo-plus-btn')) {
            curValue = curValue + 1;
            input.val(curValue);
        } else if ($(this).hasClass('woo-minus-btn') && curValue > 1) {
            curValue = curValue - 1;
            input.val(curValue);
        }

        // make update happens
        input.click();
    });

    // woocommerce checkout steps controls

    if ($('#checkpout_btn_step1').length) {
        // make all required fields as HTML5 required
        $('.woocommerce-billing-fields p.form-row.validate-required input, .woocommerce-billing-fields p.form-row.validate-required select').attr('required', '');

        $('#checkpout_btn_step1').click(function () {
            var valid = true,
                msgHtml = '<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert">',
                fieldLabel = undefined;
            $('.woocommerce-billing-fields .form-row input, .woocommerce-billing-fields .form-row select').each(function (idx, input) {
                if (!input.validity.valid) {
                    valid = false;
                    fieldLabel = $(input).closest('.form-row').find('label').clone();
                    fieldLabel.find('>*').remove();
                    fieldLabel = fieldLabel.html();
                    msgHtml += '<li><strong>' + fieldLabel + '</strong> is a required field.</li>';
                }
            });
            msgHtml += '</ul></div>';

            if (!valid) {
                $('form.woocommerce-checkout .woocommerce-NoticeGroup-checkout').remove();
                $('form.woocommerce-checkout').prepend(msgHtml);
                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: ($('form.woocommerce-checkout').offset().top - 80)
                    }, 350);
                }, 350);
                return;
            } else {
                $('form.woocommerce-checkout .woocommerce-NoticeGroup-checkout').remove();
            }

            // hide testimonials section
            $('.testi-section').addClass('d-none');

            // show tabs and update navigation
            $('.content-tabpane .content-tab').removeClass('active');
            $('.content-tabpane #checkout_payment_review_tab').addClass('active');

            $('.nav-steps-section ul li').removeClass('active');
            $('.nav-steps-section ul li:eq(1)').addClass('active');

            // update another content
            $('.lit-address-summary p').html('' + $('#billing_address_1').val() + '<br>' + $('#billing_address_2').val() + '<br>' + $('#billing_phone').val());
        });
    }

    // back to step 1 button
    if ($('#checkout_btn_backto_step1').length) {
        $('#checkout_btn_backto_step1').click(function(e) {
            e.preventDefault();
            $('.woocommerce-checkout .nav-steps-section ul li:first-child').trigger('click');
        });
    }

    // checkout navigation

    $('.woocommerce-checkout .nav-steps-section ul li:not(.disabled)').click(function () {
        var idx = $(this).index();
        var counter_validates = 0;
        $('.woocommerce-billing-fields .woocommerce-billing-fields__field-wrapper .validate-required').each(function(){
            if ($(this).find('input[type="email"]').val() == '' || $(this).find('input[type="text"]').val() == ''){
                counter_validates++;
            }
        });
        if (counter_validates==0){
            //$('.nav-steps-section ul li').removeClass('active');
            //$('.nav-steps-section ul li:eq(1)').addClass('active');
            $('.nav-steps-section ul li').removeClass('active');
            $('.nav-steps-section ul li:eq(' + idx + ')').addClass('active');
            $('.content-tabpane .content-tab').removeClass('active');
            $('.content-tabpane .content-tab:eq(' + idx + ')').addClass('active');
        }

        

        // show testimonials section
        if (idx == 0) {
            $('.testi-section').removeClass('d-none');
        }
    });

    // Update checkout step2 fields when quantity changes on step-1
    if ($('.woocommerce-checkout-review-order-table').length > 0) {
        $(document).ajaxComplete(function (e, xhr, settings) {
            if (xhr.responseJSON !== undefined && xhr.responseJSON.fragments['.woocommerce-checkout-review-order-table']) {
                var productTotal = $('#checkout_billing_shipping_tab .product-total').html(),
                    subTotal = $('#checkout_billing_shipping_tab .cart-subtotal').html(),
                    taxTotal = $('#checkout_billing_shipping_tab .tax-total').html(),
                    orderTotal = $('#checkout_billing_shipping_tab .order-total').html();

                $('#checkout_payment_review_tab .product-total').html(productTotal);
                $('#checkout_payment_review_tab .cart-subtotal').html(subTotal);
                $('#checkout_payment_review_tab .tax-total').html(taxTotal);
                $('#checkout_payment_review_tab .order-total').html(orderTotal);
            }
        });

    }

    // update another content
    $('#shipping_address_1, #shipping_address_2, #shipping_phone').focusout(function () {
        $('.lit-address-shipping p').html('' + $('#shipping_address_1').val() + '<br>' + $('#shipping_address_2').val());
    });


    // $('.woocommerce-shipping-fields h3 label').on('click', function() {
    //     $('.lit-address-summary').slideToggle(300);
    // })

    $('#shipping_method li label').on('click', function () {
        // alert('fda');
        $('.lit-step2-summary-text .lit-step2-shipping-method').text($(this).text());
    });

    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();

        var self = $(this);

        var target = this.hash;
        $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - 100
        }, 1000, function () {
            window.location.hash = target;
            $('a[href^="#"]').removeClass('on-section');
            self.addClass('on-section');
        });
    });
});

function fireCloseColorPopup() {
    var current_color = jQuery('.custom_options_select_color:checked').val();
    if( current_color != variation_color ) {
        if( variation_color ) {
            jQuery('.custom_options_select_color[value="'+variation_color+'"]').trigger('click');
        }
        else {
            jQuery('.custom_options_select_color').removeAttr('checked');
            jQuery('#pa_strap-color').prop('selectedIndex', 0);
        }
    }
}