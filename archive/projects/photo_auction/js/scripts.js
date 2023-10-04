$(function() {


    $('ul#options li img').click(function() {
        $('ul#options li img').removeClass('selected');
        $(this).addClass('selected');

        var imageName = $(this).attr('alt');

        $('#featured img').attr('src', 'images/featured/' + imageName);

        var chopped = imageName.split('.');
        $('#featured h2').remove();
        $('#featured')
           .prepend('<h2>' + chopped[0] + '</h2>')
           .children('h2')
           .fadeIn(500)
           .fadeto(200, .6);

    });

    $('ul#options li a').click(function() {
        return false;
    });
});