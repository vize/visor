<?php

namespace Visor;

use \Supervisord\Connection;

class Group
{
    private $name;
    
    /**
     * Create a new Visor process group
     * 
     * @param string $name Group name
     */
    public function __construct( $name )
    {
        $this->name = $name;
    }
    
    /**
     * Add a new process group
     * 
     * @param Connection $connection
     * @param int $priority Group start priority
     * @return boolean Always return true unless error
     * @throws \Supervisord\RpcException
     */
    public function save( Connection $connection, $priority = 999 )
    {
        return $connection->call( 'twiddler.addGroup', array( $this->name, $priority ) );
    }
    
    /**
     * Remove all stopped processes and and delete group
     * 
     * @param Connection $connection
     * @return boolean Indicates whether the removal was successful
     * @throws \Supervisord\RpcException
     */
    public function delete( Connection $connection )
    {
        return $connection->call( 'supervisor.removeProcessGroup', array( $this->name ) );
    }
    
    /**
     * Start all processes in the group
     * 
     * @param Connection $connection
     * @param boolean $wait Wait for each process to be fully stopped
     * @return array Always A structure containing start statuses
     * @throws \Supervisord\RpcException
     */
    public function start( Connection $connection, $wait = false )
    {
        return $connection->call( 'supervisor.startProcessGroup', array( $this->name, $wait ) );
    }
    
    /**
     * Stop all processes in the process group
     * 
     * @param Connection $connection
     * @param boolean $wait Wait for each process to be fully stopped
     * @return boolean Always return true unless error
     * @throws \Supervisord\RpcException
     */
    public function stop( Connection $connection, $wait = false )
    {
        return $connection->call( 'supervisor.stopProcessGroup', array( $this->name, $wait ) );
    }
    
    /**
     * Get the group name
     * 
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
