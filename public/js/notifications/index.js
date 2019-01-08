$(".accept").on('click', function () {
    $.ajax({
        url: "/friends/accept/" + $(this).attr('data-friend')
    }).done(function( data ) {
        if(data === 1)
            location.reload();
    });
});

$(".decline").on('click', function () {
    $.ajax({
        url: "/friends/decline/" + $(this).attr('data-friend')
    }).done(function( data ) {
        if(data === 1)
            location.reload();
    });
});