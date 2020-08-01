<?php
/**
 * Created by PhpStorm.
 * User: mofet
 * Date: 27/07/2017
 * Time: 15:27
 */
if (!defined('MOODLE_INTERNAL')) {
    require_once("../../../config.php");
}
require_once ('Vimeo/Vimeo.php');

global $USER;
$username = $USER->username;

$clientId   = trim(get_config('vimeo', 'client_id'));
$clientPass = trim(get_config('vimeo', 'client_pass'));
$token      = trim(get_config('vimeo', 'token'));

$vimeoHelper = new Vimeo\Vimeo ( $clientId, $clientPass, $token  );
$getAllVideosCall = NULL;
try{
    $getAllVideosCall = $vimeoHelper->request("/me/videos",array(),"GET");
}catch (Exception $e){
    var_dump(  $e  );
}

// Debug
//var_dump($getAllVideosCall['body']);

if( is_array($getAllVideosCall) == FALSE ){
    echo 'Something went wrong !!';
    return;
}

$getAllVideosCall = $getAllVideosCall["body"]["data"];

$videoIds = array();
$datareturned = array();
$videosData = array();

foreach ( $getAllVideosCall as $v ){
    //$tagsArr =  $v["tags"];

    //foreach ($tagsArr as $tag) {

        //if ($username == $tag["name"]) {
            $videoId = $v["uri"];
            $videoName = $v["name"];
            $videPic = $v["pictures"]["sizes"][0]["link"];
            if ($videoId != NULL) {
                $videoId = explode("/", $videoId);
                $videosData[] = array(
                    'video_id' => $videoId["2"],
                    'video_name' => $videoName,
                    'video_pic' => $videPic,
                );
            }
        //}
    //}
}

// Debug
//var_dump($videosData);

foreach (  $videosData as $videoData ){
    $videoId= $videoData["video_id"];
    $name = $videoData["video_name"];
    $pic = $videoData["video_pic"];
    $datareturned[] = "<div class=\"vimeo_movie\" video-id=\"$videoId\"  ><img src=\"$pic\" width=\"60\" height=\"60\"><label class=\"txt_mov\">$name</label></div>";
}

echo json_encode($datareturned);


