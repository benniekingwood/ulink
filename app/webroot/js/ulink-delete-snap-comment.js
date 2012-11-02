$("[id^=delete-snap-comment]").click(function() {
    // grab the unique user id from the element's id
    var id = $(this).attr('id').split("-")[3];
    var full_id = $(this).attr('id');
    // build the url
    var url = hostname + "snapshots/delete_snap_comment/" + id;
    // perform get request, jquery version is efficient
    var jqxhr = $.get(url, function() {})
    .success(function(response) {
        var json = $.parseJSON(response);
        if (json.result == "true") {
            // hide the comment
            $('#'+full_id).parent().hide('slow');
        } else if (json.result == "false") {
            // show error alert
            showAlertError();
        }
    })
    .error(function() {
        // show error alert
        showAlertError();
    });
});
/**
 * This function will display the alert error box
 */
function showAlertError() {
    // show the alert box with an error
    $('#snap-comments-alert').removeClass('alert-warn');
    $('#snap-comments-alert').addClass('alert-error');
    $('#snap-comments-alert').html('There was an issue deleting your comment.  Please try again later.');
    $('#snap-comments-alert').show('slow');
    $('.snap-comments-list').animate({ scrollTop: 0 }, 2700);
    setTimeout(function() {$('#snap-comments-alert').hide('slow');}, 5000);
}

