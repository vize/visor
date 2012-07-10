<?php

namespace Visor\Cli;

class Shell
{
    public function exec( $command )
    {
        $exitCode = 0;
        $output = exec( $command . ' 2>&1', $lines, $exitCode );
        
        if( $exitCode > 0 )
        {
            throw new CliException( $output, $exitCode );
        }
        
        return $output;
    }
}
