$.ajax({
    url: "/notifications/getMyFriendshipNotifications"
}).done(function( data ) {
    $('#notifCounter').html(data);
});

$(document).ready(function() {
    $('#form_pseudo').select2();
});