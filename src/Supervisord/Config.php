<?php

namespace Supervisord;

class Config extends \ArrayObject
{
    const EOL = "\r\n";
    
    public function import( \SplFileObject $file, $section = 'global' )
    {
        foreach( $file as $line )
        {
            // Remove Whitespace
            $line = trim( $line );
            
            // Skip Comments
            if( ';' === substr( $line, 0, 1 ) ){ continue; }
            
            // Parse Sections
            if( preg_match( '_^\[(?<section>.+)\]_', $line, $match ) ){
                $section = $match[ 'section' ];
                $this[ $section ] = array();
            }

            // Parse Settings
            else if( preg_match( '_^(?<key>.+)=(?<value>.+)_', $line, $match ) ){
                $this[ $section ][ trim( $match[ 'key' ] ) ] = trim( strstr( $match[ 'value' ] . ';', ';', true ) );
            }
        }
    }
    
    public function export()
    {
        $file = '';
        
        foreach( $this as $heading => $data )
        {
            $file .= sprintf( '%s[%s]%s', self::EOL, $heading, self::EOL );
            
            foreach( $data as $key => $value )
            {
                $file .= sprintf( '%s=%s%s', $key, $value, self::EOL );
            }
        }
        
        return $file;
    }
    
    public function save( $path )
    {
        file_put_contents( $path, $this->export() );
    }
}