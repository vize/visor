<?php

namespace Supervisord;

class Server
{
    private $config;
    
    public function __construct( Config $config )
    {
        $this->config = $config;
    }
    
    public function start()
    {
        $this->exec( 'supervisord' );
    }
    
    public function stop()
    {
        if( !$this->isRunning() )
        {
            throw new ServerException( 'Server not running' );
        }
        
        $this->exec( sprintf( 'kill -QUIT %s', $this->getPid() ) );
    }
    
    public function clearLogs()
    {
        if( !$this->isRunning() )
        {
            throw new ServerException( 'Server not running' );
        }
        
        $this->exec( sprintf( 'kill -USR2 %s', $this->getPid() ) );
    }
    
    public function reload()
    {
        if( !$this->isRunning() )
        {
            throw new ServerException( 'Server not running' );
        }
        
        $this->exec( sprintf( 'kill -HUP %s', $this->getPid() ) );
    }
    
    public function restart()
    {
        if( !$this->isRunning() )
        {
            $this->start();
        }
        
        else $this->reload();
    }
    
    public function isRunning()
    {
        return isset( $this->config[ 'supervisord' ][ 'pidfile' ] ) && is_readable( $this->config[ 'supervisord' ][ 'pidfile' ] );
    }
    
    public function getPid()
    {
        if( !$this->isRunning() )
        {
            throw new ServerException( 'Could not read PID file, is the server running?' );
        }
        
        return (int) file_get_contents( $this->config[ 'supervisord' ][ 'pidfile' ] );
    }
    
    private function exec( $command )
    {
        $output = exec( $command, $lines, $exitCode );
        
        if( $exitCode > 0 )
        {
            throw new \RuntimeException( $output, $exitCode );
        }
        
        return $output;
    }
}