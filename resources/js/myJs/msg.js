$(document).ready(function () {
    // Show progress bar on page load
    $('#loading-progress').show();

    // Hide the main content initially
    $('#main-content').hide();

    // Triggered when the entire page (including images and other resources) has finished loading
    $(window).on('load', function () {
        // Set progress bar width to 100%
        $('#loading-progress .progress-bar').css('width', '100%');

        // Hide progress bar after a short delay (you can adjust the delay as needed)
        setTimeout(function () {
            $('#loading-progress').fadeOut();
            // Show the main content
            $('#main-content').show();
        }, 500);
    });
});
