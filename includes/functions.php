<?php

function llcw_get_server_software(){
    if( isset( $_SERVER["SERVER_SOFTWARE"] ) && !empty( $_SERVER["SERVER_SOFTWARE"] ) ) {
        $server =  strtolower($_SERVER["SERVER_SOFTWARE"]);

        if ( strpos( $server ,'nginx' ) !== false ) {
            $server_software = 'nginx';
        } else if ( strpos( $server, 'apache' ) !== false ) {
            $server_software = 'apache';
        }
        return $server_software;
    }
    return false;
}


function llcw_read_config_file( $path ){
    if( file_exists( $path ) ) {
        return file_get_contents($path);
    }
    return '';
}