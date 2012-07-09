<?php

namespace Cli;

class Table
{
    const DELIMITER = '|';
    const PAD_LENGTH = 2;
    const PAD_CHAR = ' ';
    
    private $data, $headings = array();
    
    public function __construct( array $array )
    {
        if( empty( $array ) )
        {
            throw new \RuntimeException( 'Cannot draw table, empty array' );
        }
        
        $this->data = $array;
        
        foreach( $array as $row )
        {
            foreach( $row as $heading => $data )
            {
                if( !isset( $this->headings[ $heading ] ) || strlen( $data ) > $this->headings[ $heading ] )
                {
                    $this->headings[ $heading ] = strlen( $data );
                }
                
                if( strlen( $heading ) > $this->headings[ $heading ] )
                {
                    $this->headings[ $heading ] = strlen( $heading );
                }
            }
        }
    }
    
    private function preRender( $whitelist = null )
    {
        if( null === $whitelist )
        {
            $whitelist = array_keys( $this->headings );
        }
        
        $rows = array();
        
        $rows[] = $this->renderRow( array_combine( $whitelist, $whitelist ), $whitelist );
        
        foreach( $this->data as $row )
        {            
            $rows[] = $this->renderRow( $row, $whitelist );
        }
        
        return $rows;
    }
    
    public function render( $whitelist = null )
    {
        $width = 0;
        $rows = $this->preRender( $whitelist );
        
        foreach( $this->preRender( $whitelist ) as $line )
        {
            if( strlen( $line ) > $width )
            {
                $width = strlen( trim( $line ) );
            }
        }
        
        echo str_pad( str_repeat( '-', $width -2 ), $width, '+', \STR_PAD_BOTH ) . \PHP_EOL;
        echo array_shift( $rows ); 
        echo str_pad( str_repeat( '-', $width -2 ), $width, '+', \STR_PAD_BOTH ) . \PHP_EOL;
        
        foreach( $rows as $line )
        {
            echo $line;
        }
        
        echo str_pad( str_repeat( '-', $width -2 ), $width, '+', \STR_PAD_BOTH ) . \PHP_EOL;
    }
    
    private function renderRow( $row, $whitelist )
    {
        $output = '';
        
        foreach( $whitelist as $heading )
        {
            if( isset( $row[ $heading ] ) )
            {
                $output .= self::DELIMITER . str_pad( $row[ $heading ], $this->headings[ $heading ] + self::PAD_LENGTH, self::PAD_CHAR, \STR_PAD_BOTH );

                if( $heading === end( $whitelist ) ) $output .= self::DELIMITER;
            }
        }
        
        return $output . \PHP_EOL;
    }
}
