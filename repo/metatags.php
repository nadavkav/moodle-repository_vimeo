<?php
/**
 * Created by PhpStorm.
 * User: Tamirya
 * Date: 25/07/2017
 * Time: 15:11
 */

if( $_POST['site']  ){

    $site = $_POST['site'];
    $data = get_meta_tags($site);
    echo json_encode( $data ) ;
}