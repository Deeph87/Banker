$.ajax({
    url: "/notifications/getMyNotifications"
}).done(function( data ) {
    $('#notifCounter').html(data);
});