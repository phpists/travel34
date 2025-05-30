jQuery(function ($) {

    var $body = $('body');

    var busy = false;

    function busyOn() {
        busy = true;
        $.alerts.busyOn();
    }

    function busyOff() {
        busy = false;
        $.alerts.busyOff();
    }

    // форма нового элемента
    $body.on('click', '.add-element', function (e) {
        e.preventDefault();
        if (busy) return;
        busyOn();

        var $this = $(this), url = $this.attr('data-href'), $section = $this.closest('.elements-section');

        // сброс вида всех элементов
        $section.find('.new-element-container, .edit-element-container').html(''); // все формы уберем
        $section.find('.element').show(); // все элементы покажем

        $section.find('.new-element-container').load(url, function (response, status, xhr) {
            busyOff();
            var $new_container = $section.find('.new-element-container');
            if (status === 'error') {
                $new_container.html('');
                showXhrError(xhr);
            } else {
                $section.find('.add-element').hide();
                var offset = $new_container.offset().top;
                $('html,body').animate({scrollTop: offset - 10}, 200);
                // init
                setFormEffects();
            }
        });
    });

    // форма редактирования элемента
    $body.on('click', '.edit-element', function (e) {
        e.preventDefault();
        if (busy) return;
        busyOn();

        var $this = $(this), url = $this.attr('data-href'), $section = $this.closest('.elements-section');

        // сброс вида всех элементов
        $section.find('.new-element-container, .edit-element-container').html(''); // все формы уберем
        $section.find('.element').show(); // все элементы покажем

        $this.closest('.element-container').find('.edit-element-container').load(url, function (response, status, xhr) {
            busyOff();
            var $edit_container = $this.closest('.element-container').find('.edit-element-container');
            if (status === 'error') {
                $this.closest('.element').show();
                $edit_container.html('');
                showXhrError(xhr);
            } else {
                $this.closest('.element-container').addClass('element-editting');
                $section.find('.add-element').hide();
                $this.closest('.element').hide();
                var offset = $edit_container.offset().top;
                $('html,body').animate({scrollTop: offset - 10}, 200);
                // init
                setFormEffects();
            }
        });
    });

    // Отмена формы
    $body.on('click', '.new-element-container .cancel-form', function () {
        var $section = $(this).closest('.elements-section');
        $section.find('.new-element-container').html('');
        $section.find('.add-element').show();
        $section.find('.element-container').removeClass('element-editting');
    });
    $body.on('click', '.edit-element-container .cancel-form', function () {
        var $section = $(this).closest('.elements-section');
        $section.find('.edit-element-container').html('');
        $section.find('.element').show();
        $section.find('.add-element').show();
        $section.find('.element-container').removeClass('element-editting');
    });

    // удаление элемента
    $body.on('click', '.delete-element', function (e) {
        e.preventDefault();
        if (busy) return;
        if (!confirm('Удалить?')) return;
        busyOn();

        var $this = $(this), url = $this.attr('data-href'), $section = $this.closest('.elements-section');

        // сброс вида всех элементов
        $section.find('.new-element-container, .edit-element-container').html(''); // все формы уберем
        $section.find('.element').show(); // все элементы покажем
        $section.find('.element-container').removeClass('element-editting');

        $.post(url, function () {
            $this.closest('.element-container').remove();
            busyOff();
        }).fail(function () {
            busyOff();
            showErrorMsg('Server Error');
        });
    });

    // отправка форм нового элемента
    $body.on('submit', '.new-element-container form', function (e) {
        e.preventDefault();
        //console.log('new');

        var $form = $(this),
            $section = $form.closest('.elements-section');
        var $container = $section.find('.elements-container');

        $form.ajaxSubmit({
            dataType: 'html',
            beforeSubmit: function () {
                busyOn();
                $form.find('.btn').attr('disabled', true);
            },
            error: function () {
                busyOff();
                $form.find('.btn').attr('disabled', false);
                showErrorMsg('Server Error');
            },
            success: function (data) {
                busyOff();
                if ($(data).find('.element').length) {
                    $container.append(data);
                    $form.closest('.new-element-container').html('');
                    $section.find('.add-element').show();
                    $section.find('.element-container').removeClass('element-editting');
                } else {
                    $form.find('.btn').attr('disabled', false);
                    // upd form
                    var form_id = $form.attr('id');
                    if ($(data).find('#' + form_id + ' .alert-block').length) {
                        $form.find('.alert-block').remove();
                        $form.prepend($(data).find('#' + form_id + ' .alert-block').clone());
                    }
                }
            }
        });
    });

    // отправка формы редактирования элемента
    $body.on('submit', '.edit-element-container form', function (e) {
        e.preventDefault();
        //console.log('edit');

        busyOn();
        var $form = $(this),
            $section = $form.closest('.elements-section');

        $form.ajaxSubmit({
            dataType: 'html',
            beforeSubmit: function () {
                busyOn();
                $form.find('.btn').attr('disabled', true);
            },
            error: function () {
                busyOff();
                $form.find('.btn').attr('disabled', false);
                showErrorMsg('Server Error');
            },
            success: function (data) {
                busyOff();
                if ($(data).find('.element').length) {
                    $form.closest('.element-container').replaceWith(data);
                    $section.find('.add-element').show();
                    $section.find('.element-container').removeClass('element-editting');
                } else {
                    $form.find('.btn').attr('disabled', false);
                    // upd form
                    var form_id = $form.attr('id');
                    if ($(data).find('#' + form_id + ' .alert-block').length) {
                        $form.find('.alert-block').remove();
                        $form.prepend($(data).find('#' + form_id + ' .alert-block').clone());
                    }
                }
            }
        });
    });

    function showXhrError(xhr) {
        $.alerts.showError('Error: ' + xhr.status + ' ' + xhr.statusText);
    }

    function showErrorMsg(text) {
        $.alerts.showError(text);
    }

    function setFormEffects() {
        //$('.elements-section select').select2();
    }

});