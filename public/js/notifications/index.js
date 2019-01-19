$(".accept").on('click', function () {
    $.ajax({
        url: "/friends/accept/" + $(this).attr('data-friend')
    }).done(function( data ) {
        if(data === 1)
            location.reload();
    });
    $(this).parent().replaceWith('<button type="button" class="btn btn-outline btn-outline-success disabled">Accepted !</button>');
});

$(".decline").on('click', function () {
    $.ajax({
        url: "/friends/decline/" + $(this).attr('data-friend')
    }).done(function( data ) {
        if(data === 1)
            location.reload();
    });
    $(this).parent().replaceWith('<button type="button" class="btn btn-outline btn-outline-danger disabled">Declined !</button>');
});

$(".cancel").on('click', function () {
    $.ajax({
        url: "/friends/cancel/" + $(this).attr('data-friend')
    }).done(function( data ) {
        if(data === 1)
            location.reload();
    });
    $(this).replaceWith('<button type="button" class="btn btn-outline btn-outline-warning disabled">Canceled !</button>');
});