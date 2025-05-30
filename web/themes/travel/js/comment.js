jQuery(function ($) {
    $('.b-comment__rating').on('click', 'a.b-comment__reply', function () {
        var parent_id = $(this).parents('.b-comment__rating').data('parentId');
        $('#Comment_parent_id').val(parent_id);
        $('#GtbComment_parent_id').val(parent_id);
        $('.b-reply__info').remove();
        var userName = $(this).parents('.b-comment__sub').find('.b-comment__info strong').text();
        $('.b-comment__form h3').append(' <span class="b-reply__info">для ' + userName + ' (<a href="javascript:void(0)" id="cancel__reply">Отменить</a>)</span>');
    });
    $('.b-comment__form').on('click', '#cancel__reply', function () {
        $('#Comment_parent_id').val('');
        $('#GtbComment_parent_id').val('');
        $('.b-reply__info').remove();
    });
    $('.b-comment__rating').on('click', 'a.b-comment__rate', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $parentItem = $(this).parents('.b-comment__rating');
        var commentID = $parentItem.data('parentId');
        var isPositive = $(this).hasClass('plus');
        var isActive = $(this).hasClass('active');

        if ($this.data('requestRunning')) {
            return;
        }
        $this.data('requestRunning', true);

        $.post($('#comments').attr('data-rate-url'), {
            commentID: commentID,
            isPositive: isPositive,
            isActive: isActive
        }, function (result) {
            $parentItem.find('.b-comment__rating__block').html(result);
            $this.data('requestRunning', false);
        });
    });
});