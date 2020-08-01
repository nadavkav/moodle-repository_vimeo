// A $( document ).ready() block.

    /*global $:true, opener: true */
MacamediaAPI = (function () {
        var doc,
            body,
            container,
            loggedIn,
            noItems,
            messageBox,
            errorBox,
            pageParams,
            inRefresh = false,
            initDone = false,
            Shader = (function () {
                var shader,
                    bof;

                function add() {
                    // remove previous shader
                    if (shader) {
                        shader.remove();
                    }

                    shader = $('<div />').attr('id', 'shader').appendTo(body);
                }

                function show(clickCallback) {
                    // add the shader if it doesn't exist
                    if (!shader) {
                        add();
                    }

                    if (clickCallback) {
                        shader.click(clickCallback);
                    }

                    bof = body.css('overflow');
                    doc.css('overflow', 'hidden');
                    shader.css('display', 'block').css('opacity', 0.7);
                }

                function hide() {
                    shader.css('opacity', 0).css('display', 'none');
                    body.css('overflow', bof);
                }

                return {
                    add: add,
                    show: show,
                    hide: hide
                };

            }());

        function init() {
            doc = $(document);
            body = $('body');
            show_select_dialog();
            noItems = $('#no-items').remove();
            messageBox = $('#messagebox');
            errorBox = $('<span />', { 'class': 'error' });
        }

        function show_select_dialog() {
            var url = $("#link_vimeo").val();
            var objId = url.substr(url.lastIndexOf('/') + 1);
            var title =  $('#link_vimeo').attr("f_name");
            var data = {
                'source': objId,
                'title':title
            };

            var timezone_diff = (new Date()).getTimezoneOffset() * 60000;
            var date_created = new Date(1000 * data.datecreated + timezone_diff);
            var date_modified = new Date(1000 * data.datemodified + timezone_diff);
            var h = ' בשעה ';

            data.datecreated_f = date_created.toString('dd/MM/yyyy') + h + date_created.toString('HH:mm');
            data.datemodified_f = date_modified.toString('dd/MM/yyyy') + h + date_modified.toString('HH:mm');
            data.title += '.mpg';
            var keys = Object.getOwnPropertyNames(window.parent.M.core_filepicker.instances);
            window.parent.M.core_filepicker.instances[keys[0]].select_file(data);
        }

    return {
        init:init
    };

}());

$( document ).ready(function() {
    $('input').on('paste', function () {
        var element = this;
        setTimeout(function () {
            var txt = $(element).val();
            $.post("metatags.php", {site:txt},function(data){
                if( data ){
                    data = JSON.parse(data);
                    var img = $('#vimeo_img');
                    var desc = $('#vimeo_desc');
                    var inputLink = $('#link_vimeo');
                    img.attr("src",data["twitter:image"]);
                    desc.text( data["twitter:description"] );
                    inputLink.attr("f_name", data["twitter:title"] );
                    $('#vimeo-details').removeClass("hide");
                }
            });
        }, 100);
    });


    $('#tab-pane-movies').on('click', function () {

        $('#loader-mov').show();
        $('#my_movies').hide();

        $.post("getMovies.php",function(data){
            if( data ){
                $('#loader-mov').hide();
                $('#my_movies').html('');
                $('#my_movies').show();
                data = JSON.parse(data);
                $.each( data, function( index, value ){
                    $('#my_movies').append(value);
                });

            }
        });

    });

    $('body').on("click",".vimeo_movie",function(){
        var obj = this;
        var objId = $( obj ).attr("video-id");
        var title = $( obj ).find(".txt_mov").text();
        var data = {
            'source': objId,
            'title':title
        };

        var timezone_diff = (new Date()).getTimezoneOffset() * 60000;
        var date_created = new Date(1000 * data.datecreated + timezone_diff);
        var date_modified = new Date(1000 * data.datemodified + timezone_diff);
        var h = ' בשעה ';

        data.datecreated_f = date_created.toString('dd/MM/yyyy') + h + date_created.toString('HH:mm');
        data.datemodified_f = date_modified.toString('dd/MM/yyyy') + h + date_modified.toString('HH:mm');
        data.title += '.mpg';
        var keys = Object.getOwnPropertyNames(window.parent.M.core_filepicker.instances);
        window.parent.M.core_filepicker.instances[keys[0]].select_file(data);
    });

    $("#search_video").keyup(function () {
        var filter = $(this).val();
        $(".vimeo_movie").each(function () {
            if ($(this).find(".txt_mov").text().search(new RegExp(filter, "i")) < 0) {
                $(this).addClass("hide");
            } else {
                $(this).removeClass("hide");
            }
        });
    });


});