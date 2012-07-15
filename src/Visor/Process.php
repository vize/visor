<?php

namespace Visor;

use \Supervisord\Connection;

class Process
{
    private $group, $name, $command;
    
    /**
     * Create a new Visor process
     * 
     * @param Group $group Process group
     * @param string $name Process name
     * @param string $command Command to execute
     */
    public function __construct( Group $group, $name, $command )
    {
        $this->group = $group;
        $this->name = $name;
        $this->command = $command;
    }
    
    /**
     * Start a process
     * 
     * @param Connection $connection
     * @return boolean Always return true unless error
     * @throws \Supervisord\RpcException
     */
    public function start( Connection $connection )
    {
        return $connection->call( 'supervisor.startProcess', array(
            sprintf( '%s:%s', 
                $this->group->getName(),
                $this->name
            )
        ));
    }
    
    /**
     * Stop a process
     * 
     * @param Connection $connection
     * @return boolean Always return true unless error
     * @throws \Supervisord\RpcException
     */
    public function stop( Connection $connection )
    {
        return $connection->call( 'supervisor.stopProcess', array(
            sprintf( '%s:%s', 
                $this->group->getName(),
                $this->name
            )
        ));
    }
    
    /**
     * Add a new program to an existing process group.
     * 
     * Depending on the numprocs option, this will result in one or more processes being added to the group.
     * 
     * @param Connection $connection
     * @param boolean $autostart
     * @param boolean $autorestart
     * @param int $startsecs
     * @return boolean Always return true unless error
     * @throws \Supervisord\RpcException
     */
    public function save( Connection $connection, $autostart = false, $autorestart = true, $startsecs = 1 )
    {
        return $connection->call( 'twiddler.addProgramToGroup', array(
            $this->group->getName(),
            $this->name,
            array(
                'command' => $this->command,
                'autostart' => $autostart ? 'true' : 'false',
                'autorestart' => $autorestart ? 'true' : 'false',
                'startsecs' => $startsecs = (string) $startsecs,
            )
        ));
    }
    
    /**
     * Remove a process from a process group.
     * 
     * When a program is added with save(), one or more processes for that program is added to the group.
     * This method removes individual processes (named by the numprocs and process_name options), not programs
     * 
     * @param Connection $connection
     * @return boolean Always return true unless error
     * @throws \Supervisord\RpcException
     */
    public function delete( Connection $connection )
    {
        return $connection->call( 'twiddler.removeProcessFromGroup', array(
            $this->group->getName(),
            $this->name
        ));
    }
    
    /**
     * Get info about a process named name
     * 
     * @param Connection $connection
     * @return array A structure containing data about the process
     * @throws \Supervisord\RpcException
     */
    public function getInfo( Connection $connection )
    {
        return $connection->call( 'supervisor.getProcessInfo', array(
            sprintf( '%s:%s',
                $this->group->getName(),
                $this->name
            )
        ));
    }
    
    /**
     * Read length bytes from name's stdout log starting at offset
     * 
     * @param Connection $connection
     * @param int $offset Offset to start reading from
     * @param int $length Number of bytes to read from the log
     * @return string Bytes of log
     * @throws \Supervisord\RpcException
     */
    public function readStdOut( Connection $connection, $offset = 0, $length = 1024 )
    {
        return $connection->call( 'supervisor.readProcessStdoutLog', array(
            sprintf( '%s:%s', 
                $this->getGroup()->getName(),
                $this->getName()
            ),
            $offset,
            $length
        ));
    }
    
    /**
     * Read length bytes from name's stderr log starting at offset
     * 
     * @param Connection $connection
     * @param int $offset Offset to start reading from
     * @param int $length Number of bytes to read from the log
     * @return string Bytes of log
     * @throws \Supervisord\RpcException
     */
    public function readStdErr( Connection $connection, $offset = 0, $length = 1024 )
    {
        return $connection->call( 'supervisor.readProcessStderrLog', array(
            sprintf( '%s:%s', 
                $this->getGroup()->getName(),
                $this->getName()
            ),
            $offset,
            $length
        ));
    }
    
    /**
     * Send a string of chars to the stdin of the process name.
     * 
     * If non-7-bit data is sent (unicode), it is encoded to utf-8 before being sent to the process' stdin.
     * If chars is not a string or is not unicode, raise INCORRECT_PARAMETERS. If the process is not running,
     * raise NOT_RUNNING. If the process' stdin cannot accept input (e.g. it was closed by the child process),
     * raise NO_FILE.
     * 
     * @param Connection $connection
     * @param string $string The character data to send to the process
     * @return boolean Always return True unless error
     * @throws \Supervisord\RpcException
     */
    public function sendStdin( Connection $connection, $string )
    {
        return $connection->call( 'supervisor.sendProcessStdin', array(
            sprintf( '%s:%s', 
                $this->getGroup()->getName(),
                $this->getName()
            ),
            $string
        ));
    }
    
    /**
     * Send an event that will be received by event listener subprocesses subscribing to the RemoteCommunicationEvent.
     * 
     * @param Connection $connection
     * @param string $type String for the "type" key in the event header
     * @param string $data Data for the event body
     * @return boolean Always return True unless error
     * @throws \Supervisord\RpcException
     */
    public function sendRemoteCommEvent( Connection $connection, $type, $data )
    {
        return $connection->call( 'supervisor.sendRemoteCommEvent', array( $type, $data ) );
    }
}