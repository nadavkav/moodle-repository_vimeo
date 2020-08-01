/**
 * Called when files are dropped on to the drop target or selected by the browse button.
 * For each file, uploads the content to Drive & displays the results when complete.
 */
function handleFileSelect(evt) {
    evt.stopPropagation()
    evt.preventDefault()


    var files = evt.dataTransfer ? evt.dataTransfer.files : $(this).get(0).files;
    var results = document.getElementById('results');

    if ( $('#videoName').val().length <= 0 ){
        showErrorMessage('<strong>חובה לתת שם לסרט </strong>');
        $(this).val("");
        return;
    }

    /* Clear the results div */
    while (results.hasChildNodes()) results.removeChild(results.firstChild);

    /* Rest the progress bar and show it */
    updateProgress(0);
    document.getElementById('progress-container').style.display = 'block';

    /* Instantiate Vimeo Uploader */
    (new VimeoUpload({
        name: document.getElementById('videoName').value,
        //description: document.getElementById('videoDescription').value,
        file: files[0],
        token: document.getElementById('accessToken').value,
        onError: function(data) {
            showMessage('<strong>Error</strong>: ' + JSON.parse(data).error, 'danger');
        },
        onProgress: function(data) {
            updateProgress(data.loaded / data.total);
        },
        onComplete: function(videoId, index) {
            var url = 'https://vimeo.com/' + videoId;

            if (index > -1) {
                /* The metadata contains all of the uploaded video(s) details see: https://developer.vimeo.com/api/endpoints/videos#/{video_id} */
               // url = this.metadata[index].link; //
/*
                /!* add stringify the json object for displaying in a text area *!/
                var pretty = JSON.stringify(this.metadata[index], null, 2);

                //console.log(pretty); /!* echo server data *!/
                console.log(url); /!* echo server data *!/*/
            }


            showMessage('<strong>הועלה בהצלחה</strong>');
            addTag( videoId  );
            $("#videoId").val( videoId );
        }
    })).upload();


    /* local function: show a user message */
    function showErrorMessage(html) {
        /* hide progress bar */
        document.getElementById('progress-container').style.display = 'none';

        /* display alert message */
        var element = document.createElement('div');
        element.setAttribute('class', 'alert alert-danger' );
        element.innerHTML = html;
        results.appendChild(element);
        $(element).delay(3000).fadeOut(2000);
    }


    /* local function: show a user message */
    function showMessage(html, type) {
        /* hide progress bar */
        document.getElementById('progress-container').style.display = 'none';

        /* display alert message */
        var element = document.createElement('div');
        element.setAttribute('class', 'alert alert-' + (type || 'success'));
        element.innerHTML = html;
        results.appendChild(element);
        $(element).delay(3000).fadeOut(2000);
    }

    /*  add tag to video */
    function addTag( videoId ){
        var tag = $('#username').val();
        var data = {
            "tag":tag,
            "videoId":videoId
        };

        $.ajax({
            url: "addtag.php",
            type: "post",
            data: data ,
            aysnc:false,
            success: function (response) {
                console.log("Tag Added !!");

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
}

function handleSubtitleFile(){

    var videoId = $("#videoId").val();
    if ( videoId.length == 0 ){
        /* hide progress bar */
        document.getElementById('progress-container').style.display = 'none';
        /* display alert message */
        var element = document.createElement('div');
        var results = document.getElementById('results');

        element.setAttribute('class', 'alert alert-danger');
        element.innerHTML = '<strong>תחילה העלה סרט</strong>';
        results.appendChild(element);
        $(element).delay(3000).fadeOut(2000);
        $(this).val("");
        return;
    }


    var data = new FormData();
    data.append( "filesubtitle" ,  $("#videoSubtitle")[0].files[0]  );
    data.append("videoId" , videoId );
    $("#l_subtitle").button('loading');
    $.ajax({
        url: "addsubtitle.php",
        type: "post",
        data: data ,
        contentType: false,
        processData: false,
        success: function (response) {
            /* hide progress bar */
            document.getElementById('progress-container').style.display = 'none';
            /* display alert message */
            var element = document.createElement('div');
            var results = document.getElementById('results');
            element.setAttribute('class', 'alert alert-success');
            element.innerHTML = '<strong>קובץ התרגום הועלה בהצלחה</strong>';
            results.appendChild(element);
            $(element).delay(3000).fadeOut(2000);
            $("#l_subtitle").button('reset');


        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}

/**
 * Dragover handler to set the drop effect.
 */
function handleDragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy';
}

/**
 * Updat progress bar.
 */
function updateProgress(progress) {
    progress = Math.floor(progress * 100);
    var element = document.getElementById('progress');
    element.setAttribute('style', 'width:' + progress + '%');
    element.innerHTML = '&nbsp;' + progress + '%';
}

/**
 * Wire up drag & drop listeners once page loads
 */
document.addEventListener('DOMContentLoaded', function() {


    var dropZone = document.getElementById('drop_zone');
    var browse = document.getElementById('browse');
    var videoSubtitle = document.getElementById('videoSubtitle');
    dropZone.addEventListener('dragover', handleDragOver, false);
    dropZone.addEventListener('drop', handleFileSelect, false);
    browse.addEventListener('change', handleFileSelect, false);
    videoSubtitle.addEventListener('change', handleSubtitleFile, false);
});