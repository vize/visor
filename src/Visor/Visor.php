<?php

namespace Visor;

use \Supervisord\Connection;

class Visor
{
    /**
     * Return the version of the supervisor package in use by supervisord
     * 
     * @param Connection $connection
     * @return string Version id
     * @throws \Supervisord\RpcException
     */
    public function getSuperviserVersion( Connection $connection )
    {
        return $connection->call( 'supervisor.getSupervisorVersion' );
    }
    
    /**
     * Return the version of the RPC API used by supervisor_twiddler
     * 
     * @param Connection $connection
     * @return string Version id
     * @throws \Supervisord\RpcException
     */
    public function getTwiddlerVersion( Connection $connection )
    {
        return $connection->call( 'twiddler.getAPIVersion' );
    }
    
    /**
     * Return an array listing the available method names
     * 
     * @param Connection $connection
     * @return array An array of method names available (strings)
     * @throws \Supervisord\RpcException
     */
    public function listMethods( Connection $connection )
    {
        return $connection->call( 'system.listMethods' );
    }
    
    /**
     * Return a string showing the method's documentation
     * 
     * @param Connection $connection
     * @param type $method The name of the method
     * @return string The documentation for the method name
     * @throws \Supervisord\RpcException
     */
    public function help( Connection $connection, $method )
    {
        return $connection->call( 'system.methodHelp', array( $method ) );
    }
    
    /**
     * Get info about all processes
     * 
     * @param Connection $connection
     * @return array An array of process status results
     * @throws \Supervisord\RpcException
     */
    public function getAllProcessInfo( Connection $connection )
    {
        return $connection->call( 'supervisor.getAllProcessInfo' );
    }
    
    /**
     * Find a process by group and name
     * 
     * @param Connection $connection
     * @param string $groupName Name of the group the process belongs to
     * @param string $processName Name of the process to locate
     * @return \Visor\Process The Visor process object
     * @throws \Supervisord\RpcException
     */
    public function findOne( Connection $connection, $groupName, $processName )
    {
        $info = $connection->call( 'supervisor.getProcessInfo', array(
            sprintf( '%s:%s',
                $groupName,
                $processName
            )
        ));
        
        return new Process( new Group( $info[ 'group' ] ), $info[ 'name' ], '' );
    }
}