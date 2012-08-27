(function($){

$('#speed-test-start').click(function(){
    $('#booster-stopped').html('');
    $('#booster-running').html('');
    var d = new Date();
    var path = plugins_url+'/test-images/img_r{0}_c{1}.png?ver=';
    var booster = 'http://demo.wpbooster.net/test-images/default/img_r{0}_c{1}.png?ver=';
    for (var i=1; i<=10; i++) {
        for (var j=1; j<=10; j++) {
            var img = $('<img />');
            img.attr('src', $.sprintf(path, i, j)+d.getTime());
            img.attr('width', "25");
            img.attr('height', "25");
            $('#booster-stopped').append(img);
            var img2 = $('<img />');
            img2.attr('src', $.sprintf(booster, i, j)+d.getTime());
            img2.attr('width', "25");
            img2.attr('height', "25");
            $('#booster-running').append(img2);
        }
    }
});

$.extend({
    sprintf: function(format) {
        for (var i = 1; i < arguments.length; i++) {
            var reg = new RegExp('\\{' + (i - 1) + '\\}', 'g');
            format = format.replace(reg, arguments[i]);
        }
        return format;
    }
});

})(jQuery); // EOF
