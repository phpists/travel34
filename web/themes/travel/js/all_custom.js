$(document).ready(function () {
    $(document).on('click', '.editCollection', function () {
        var collection_id = $(this).data('collection_id');

        $.ajax({
            type: "POST",
            url: '/profile/edit-collection',
            dataType: "json",
            data: {
                collection_id: collection_id
            },
            success: function (response) {
                $('#editCollectionId').val(response.collection.id);
                $('#editCollectionTitle').val(response.collection.title);
                $('#deleteCollection').attr('href', response.delete_collection);
            },

        });
    });

    $(document).on('click', '.addPostToFaves', function () {
        var post_id = $(this).data('post_id');

        $('#favoritePostId').val(post_id);
        console.log('post_id: ', post_id);
    });

    $(document).on('click', '.deleteUserCollectionPost', function () {
        var btn = $(this);
        var post_id = $(this).data('post_id');
        var post = btn.closest('.post');

        $.ajax({
            type: "GET",
            url: '/profile/delete-collection-post/' + post_id,
            dataType: "json",
            success: function (response) {

            },
        });

        post.remove();
    });

    $(document).on('click', '.deleteFavoritePost', function () {
        const post_id = $(this).data('post_id');
        const is_collection = $(this).data('is_collection');

        if (is_collection == true){
            console.log('1');
            $('#collectionBlock').css('display', 'flex');
        } else {
            console.log('2');
            $('#collectionBlock').css('display', 'none');
        }

        $('#deleteFavoritePostId').val(post_id);
    });

    $(document).on('click', '.addPostViewToFaves', function () {
        var post_id = $(this).data('post_id');
        var is_reload = $(this).data('is_reload');

        $('.new-select').find('span').text('... без коллекции');
        $('#choose_post_collection option[value=""]').prop('selected', true);
        $('#favoritePostViewId').val(post_id);
        $('#favoriteIsReload').val(is_reload);
    });

    $(document).on('submit', '.addPostViewToFavesForm', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();
        var postId = data.find(item => item.name === 'post_id')?.value;

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                if (response.status) {
                    $('#form_add_post_view').find('.mfp-close').trigger('click');

                    if (response.is_reload == true) {
                        location.reload();
                    }

                    $('.svg_' + postId).attr('fill', 'black');
                }
            },
        });
    });

    $(document).on('submit', '.addCollectionViewForm', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                if (response.status) {

                    $('#form_create_collection_post_view').find('.mfp-close').trigger('click');

                    $('.new-select').removeClass('empty');

                    $('.new-select__list').append('<div class="new-select__item" data-value="' + response.collection.id + '"><span>' + response.collection.title + '</span></div>')
                        .promise().done(function () {
                        const _this = $('#choose_post_collection');
                        const duration = 450;
                        const selectHead = _this.next('.new-select');
                        const selectHeadBlock = selectHead.find('span');
                        const selectList = selectHead.next('.new-select__list');
                        const selectItem = selectList.find('.new-select__item');

                        selectItem.on('click', function () {
                            let chooseItem = $(this).data('value');

                            $('select').val(chooseItem).attr('selected', 'selected');
                            selectHeadBlock.text($(this).find('span').text());

                            selectList.slideUp(duration);
                            selectHead.removeClass('on');
                        });

                    });

                    $('#choose_post_collection').append($('<option>', {
                        value: response.collection.id,
                        text: response.collection.title,
                        selected: true
                    }));

                    $.magnificPopup.open({
                        items: {
                            src: '#form_add_post_view',
                            type: 'inline'
                        }
                    });

                    $('#addCollectionInput').val('');
                }
            },
        });
    });

    $(document).on('submit', '.addCollectionViewFormInAccount', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                if (response.status) {
                    window.location.href = "/profile/collections";
                }
            },
        });
    });

    $(document).on('click', '.deleteFromCollection', function () {
        var post_id = $(this).data('post_id');

        $.ajax({
            type: "POST",
            url: '/profile/delete-from-user-collection/' + post_id,
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    location.reload();
                }
            },
        });
    });

    $(document).on('click', '.deleteFromFavorites', function () {
        var post_id = $(this).data('post_id');

        $.ajax({
            type: "POST",
            url: '/profile/delete-from-favorites/' + post_id,
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    location.reload();
                }
            },
        });
    });

    // $(document).on('change', '#terms', function () {
    //     if (this.checked) {
    //         $('.paymentBtn').removeClass('paymentDisable');
    //     } else {
    //         $('.paymentBtn').addClass('paymentDisable');
    //     }
    // });

    $(document).on('click', '.btnUserSubscription', function () {
        const user_subscription_id = $(this).data('user_subscription_id');
        const end_date = $(this).data('end_date');

        $('#subscriptionUserId').val(user_subscription_id);
        $('#subscriptionEndDate').text(end_date);
    });

    $(document).on('click', '.closeModal', function () {
        $('.mfp-close').trigger('click');
    });

    $(document).on('submit', '#gift_promo__form', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                if (response.status === 'error') {
                    $('.form_promo_error').text(response.message).css('display', 'block');
                } else {
                    $('.form_promo_success').text(response.message).css('display', 'block');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            },
        });
    });

    /* Сookies */
    function cookieOff() {
        if ($.cookie('user_agree')) {
            $(".bottom__cookies").addClass("closed")
        }

        $("#cookies__cancel").on("click", function () {
            $.cookie("user_agree", "Off", {expires: 72 / 24});
            $(".bottom__cookies").addClass("closed")
        })
    }

    cookieOff();

    $(document).on('submit', '#form_cookie', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                if (response.status === 'true') {
                    $(".bottom__cookies").addClass("closed");
                    $('.mfp-close').trigger('click');
                }
            },
        });
    });

    $(document).on('click', '.subscription__tariffs_check', function () {
        var subscription = $(this).find('label').text();
        $('#subscriptionText').val(subscription);
    });

    $(document).on('click', '.square-radio', function () {
        var type = $(this).find('label').text();
        $('#subscriptionTypeText').val(type);
    });

    /**
     * Tariff Subscription Form
     */
    $(document).on('submit', '#check_subscription', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'subscription_form_submit',
                    formClasses: document.querySelector('form').className || '',
                    formElement: document.querySelector('form').outerHTML || '',
                    formID: document.querySelector('form').id || '',
                    formTarget: document.querySelector('form').target || '',
                    formText: document.querySelector('form').innerText || '',
                    formURL: document.querySelector('form').action || '',
                    subscriptionText: response.params.subscription_text,
                    subscriptionTypeText: response.params.subscription_type_text,
                    clickClasses: '',
                    clickElement: '',
                    clickID: '',
                    clickTarget: '',
                    clickText: '',
                    clickURL: ''
                });

                console.log('subscription_form_submit');
                console.log(response.params.subscription_text);
                console.log(response.params.subscription_type_text);

                setTimeout(function () {
                    window.location.replace(response.url);
                }, 500);
            },
        });
    });

    /**
     * Payment Btn
     */
    $(document).on('click', '.paymentBtn', function (e) {
        e.preventDefault();
        let url = $(this).data('url');

        if ($('#terms').is(':checked')) {
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: 'payment_form_submit',
                formClasses: document.querySelector('form').className || '',
                formElement: document.querySelector('form').outerHTML || '',
                formID: document.querySelector('form').id || '',
                formTarget: document.querySelector('form').target || '',
                formText: document.querySelector('form').innerText || '',
                formURL: document.querySelector('form').action || '',
                paymentText: 'Оплата успешно создана',
                clickClasses: '',
                clickElement: '',
                clickID: '',
                clickTarget: '',
                clickText: '',
                clickURL: ''
            });

            console.log('payment_form_submit');

            setTimeout(function () {
                window.location.replace(url);
            }, 500);
        } else {
            $('.subscription__terms').addClass('redBorder');
            console.log('some1')
        }
    });

    $(document).on('submit', '.mySelfForm', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'for_whom_subscription',
                    formClasses: document.querySelector('form').className || '',
                    formElement: document.querySelector('form').outerHTML || '',
                    formID: document.querySelector('form').id || '',
                    formTarget: document.querySelector('form').target || '',
                    formText: document.querySelector('form').innerText || '',
                    formURL: document.querySelector('form').action || '',
                    paymentText: 'Для себя',
                    clickClasses: '',
                    clickElement: '',
                    clickID: '',
                    clickTarget: '',
                    clickText: '',
                    clickURL: ''
                });

                setTimeout(function () {
                    window.location.replace(response.url);
                }, 500);
            },
        });
    });

    $(document).on('click', '.giftForm', function (e) {
        e.preventDefault();

        var form = $(this)
        var data = form.serializeArray();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            dataType: "json",
            data: data,
            success: function (response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'for_whom_subscription',
                    formClasses: document.querySelector('form').className || '',
                    formElement: document.querySelector('form').outerHTML || '',
                    formID: document.querySelector('form').id || '',
                    formTarget: document.querySelector('form').target || '',
                    formText: document.querySelector('form').innerText || '',
                    formURL: document.querySelector('form').action || '',
                    paymentText: 'В подарок',
                    clickClasses: '',
                    clickElement: '',
                    clickID: '',
                    clickTarget: '',
                    clickText: '',
                    clickURL: ''
                });

                setTimeout(function () {
                    window.location.replace(response.url);
                }, 500);
            },
        });
    });
});