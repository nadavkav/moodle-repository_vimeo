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

$clientId   = trim(get_config('macamvimeo', 'client_id'));
$clientPass = trim(get_config('macamvimeo', 'client_pass'));
$token      = trim(get_config('macamvimeo', 'token'));


$vimeoHelper = new Vimeo\Vimeo ( $clientId, $clientPass, $token  );

$videoId = $_POST["videoId"];
$tag = $_POST["tag"];
$tag = rawurlencode($tag);

try{
    $addTagCall = $vimeoHelper->request("/videos/$videoId/tags/$tag",array(),"PUT");
}catch (Exception $e){
    var_dump(  $e  );
}