<?php

if ( !function_exists( 'list_model_names' ) ) {
    function get_model_names()
    {
        try {
            $path = config( 'ltm.model_folder' );
            $out  = [];

            $results = scandir( $path );

            foreach ( $results as $result ) {

                if ( '.' === $result or '..' === $result ) {
                    continue;
                }

                $filename = $path . '/' . $result;

                if ( is_dir( $filename ) ) {
                    $out = array_merge( $out, get_model_names( $filename ) );
                } else {
                    $out[] = substr( $result, 0, -4 );
                }

            }

            return $out;
        } catch ( \Exception $ex ) {
            return [];
        }

    }

}

if ( !function_exists( 'get_placeholder_params' ) ) {
    function get_placeholder_params( $translationItem )
    {
        
    }

}

if ( !function_exists( 'is_string_translation' ) ) {
    function is_string_translation( $translation )
    {

        if ( is_object( $translation ) ) {

            if ( $translation->group == '*' || empty( $translation->group ) ) {
                return true;
            }

        }

        if ( is_string( $translation ) ) {

            if ( $translation == '*' || empty( $translation ) ) {
                return true;
            }

        }

        return false;
    }

}
