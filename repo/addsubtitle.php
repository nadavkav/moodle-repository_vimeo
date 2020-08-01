<?php
/**
 * Tamir Yakar
 * Date: 27/07/2017
 * Time: 10:53
 */

if (!defined('MOODLE_INTERNAL')) {
    require_once("../../../config.php");
}
require_once ('Vimeo/Vimeo.php');


if( count( $_FILES ) == 0  ){
    return;
}

$video_subtitle_name = $_FILES["filesubtitle"]["name"];
$videoId = $_POST["videoId"];


$clientId   = trim(get_config('vimeo', 'client_id'));
$clientPass = trim(get_config('vimeo', 'client_pass'));
$token      = trim(get_config('vimeo', 'token'));

$vimeoHelper = new Vimeo\Vimeo ( $clientId, $clientPass, $token  );



try{
    $video = $vimeoHelper->request("/videos/$videoId",array(),"GET");
    $texttracksUrl = $video["body"]["metadata"]["connections"]["texttracks"]["uri"];
    $texttracksReq = $vimeoHelper->request($texttracksUrl,array(
        "type"=>"subtitles",
        "language"=>"en",
        "name"=>$video_subtitle_name,
    ),"POST");

    $upload_url = $texttracksReq["body"]["link"];


    $file_path =  $_FILES["filesubtitle"]['tmp_name'];
    $texttrack_resource = fopen($file_path, 'r');


    $curl_opts = [
        CURLOPT_HEADER => 1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 240,
        CURLOPT_UPLOAD => true,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_READDATA => $texttrack_resource
    ];

    $curl = curl_init($upload_url);
    curl_setopt_array($curl, $curl_opts);
    $response = curl_exec($curl);
    $curl_info = curl_getinfo($curl);

    if (!$response) {
        $error = curl_error($curl);
        throw new Exception($error);
    }

    curl_close($curl);


}catch (Exception $e){
    var_dump(  $e  );
}