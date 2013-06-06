<?php
function UnicodeToUtf8( $str ) {
    
    $utf8 = '';
    
    foreach( $str as $unicode ) {
    
        if ( $unicode < 128 ) {

            $utf8.= chr( $unicode );
        
        } elseif ( $unicode < 2048 ) {
            
            $utf8.= chr( 192 +  ( ( $unicode - ( $unicode % 64 ) ) / 64 ) );
            $utf8.= chr( 128 + ( $unicode % 64 ) );
                    
        } else {
            
            $utf8.= chr( 224 + ( ( $unicode - ( $unicode % 4096 ) ) / 4096 ) );
            $utf8.= chr( 128 + ( ( ( $unicode % 4096 ) - ( $unicode % 64 ) ) / 64 ) );
            $utf8.= chr( 128 + ( $unicode % 64 ) );
            
        } // if
        
    } // foreach

    return $utf8;

} // unicode_to_utf8
?>