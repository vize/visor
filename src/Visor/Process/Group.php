<?php

namespace Visor\Process;

use \Supervisord\Client;

class Group
{
    private $client,
            $name,
            $command,
            $priority,
            $children;
    
    public function __construct( Client $client, $name, $command, $priority = 999 )
    {
        $this->client = $client;
        $this->name = $name;
        $this->command = $command;
        $this->priority = $priority;
        $this->children = array();
    }
    
    public function run( $total )
    {
        $current = $this->count();
        
        if( $total > $current )
        {
            for( $x=0; $x<$total-$current; $x++ )
            {
                $this->create( md5( rand( 0, \PHP_INT_MAX ) ) );
            }
        }
        
        return $this;
    }
    
    private function create( $procName )
    {
        $groups = $this->client->getGroupNames();
        
        // Create the group if required
        if( !is_array( $groups ) || !in_array( $this->name, $groups ) )
        {
            $this->client->addGroup( $this->name, $this->priority );
        }
        
        // Create a new process
        $this->client->addProgramToGroup( $this->name, $procName, array(
            'command' => $this->command,
            'autostart' => 'false',
            'autorestart' => 'true',
            'startsecs' => 1,
        ));
    }
    
    public function load()
    {
        $children = array();
        $allProcs = $this->client->getAllProcessInfo();
        
        if( is_array( $allProcs ) )
        {
            foreach( $allProcs as $proc )
            {
                if( isset( $proc[ 'group' ], $proc[ 'name' ] ) && $proc[ 'group' ] === $this->name )
                {
                    $children[] = sprintf( '%s:%s', $proc[ 'group' ], $proc[ 'name' ] );
                }
            }
        }
        
        return $children;
    }
    
    public function count()
    {
        return count( $this->load() );
    }
}
