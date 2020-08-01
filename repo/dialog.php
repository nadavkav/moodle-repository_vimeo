<?php

if (!defined('MOODLE_INTERNAL')) {
    require_once("../../../config.php");
}

global $USER;
$lang = current_language();
$token      = trim(get_config('macamvimeo', 'token'));
$username = $USER->username;
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="Content-Encoding" content="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
<!--    <link rel="stylesheet" href="style.css"> -->

    <!-- Latest compiled and minified CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
    <?php if( $lang == "he") {?>
        <link rel="stylesheet" href="main.css" />
    <?php }else{ ?>
        <link rel="stylesheet" href="general.css" />
    <?php } ?>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <div id="exTab2" class="container">
        <ul class="nav nav-tabs right-to-left">
            <li class="active" >
                <a  href="#tab-pane-1" data-toggle="tab"> <?= get_string("vimeo_video_link","repository_macamvimeo")  ?> </a>
            </li>
            <li>
                <a href="#tab-pane-2" data-toggle="tab"><?= get_string("vimeo_video_link_upload","repository_macamvimeo")  ?></a>
            </li>
            <li  id="tab-pane-movies" >
                <a href="#tab-pane-3" data-toggle="tab" ><?= get_string("vimeo_video_my_videos","repository_macamvimeo")  ?></a>
            </li>
        </ul>

        <div class="tab-content ">
            <div class="tab-pane active " id="tab-pane-1">
                <div id="items-wrapper" class="wrapper">
                    <h2><?= get_string("vimeo_insert_link_title","repository_macamvimeo") ?></h2>

                    <div id="items-content">
                        <div id="items">
                            <div class="item">
                                <input type="hidden" id="accessToken" value="<?= $token  ?>" >
                                <input type="hidden" id="username" value="<?= $username  ?>" >
                                <input type="text" class="col-md-4" id="link_vimeo"  f_name="" >
                                <button type="button" class="btn btn-primary" id="btn-link-vimeo" onclick="window.MacamediaAPI.init();" ><?= get_string("vimeo_insert_link_select","repository_macamvimeo") ?></button>
                                <div class="row hide" id="vimeo-details">
                                    <div class="col-xs-3">
                                        <img src="" id="vimeo_img" class="img-circle" width="80" height="80" />
                                    </div>
                                    <div class="col-xs-9">
                                        <p id="vimeo_desc" ></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab-pane-2">
                <div id="progress-container" class="progress">
                    <div id="progress" class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100" style="width: 0%">&nbsp;0%</div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="results"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="name" id="videoName" class="form-control" placeholder="<?= get_string("vimeo_video_name","repository_macamvimeo") ?>" value="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="drop_zone">Drop File Here</div>
                        <br/>
                        <label class="btn btn-block btn-info"><?= get_string("vimeo_video_file_upload","repository_macamvimeo")  ?><input id="browse" type="file" style="display: none;"></label>
                    </div>
                </div>

                <hr />
                <div class="form-group">
                    <h4><?= get_string("vimeo_video_file_subtitle","repository_macamvimeo") ?></h4>
                    <label class="btn btn-block btn-success" id="l_subtitle" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> מעבד נתונים"><?= get_string("vimeo_video_file_upload","repository_macamvimeo")  ?><input id="videoSubtitle" type="file" style="display: none;"></label>
                    <input type="hidden" name="videoId" id="videoId" class="form-control" />
                </div>

            </div>

            <div class="tab-pane" id="tab-pane-3">

                <div class="row">
                    <input class="col-md-12"  type="text" id="search_video" placeholder="<?= get_string("vimeo_video_search","repository_macamvimeo")  ?>"  />
                    <div class="container" id="loader-mov" style="display: none;">
                        <img src="img/ajax-loader.gif" width="30" height="30" />
                    </div>

                    <div class="col-md-12" id="my_movies"></div>
                </div>

            </div>

        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/websemantics/bragit/0.1.2/bragit.js"></script>
<script type="text/javascript" src="vimeo-upload.js"></script>
<script type="text/javascript" src="helper.js"></script>
<script src="core.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>