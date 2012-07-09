<?php

namespace Visor;

class Process
{
    private $description,
            $pid,
            $stdErrorLog,
            $stop,
            $logFile,
            $exitStatus,
            $spawnerr,
            $now,
            $group,
            $name,
            $statename,
            $start,
            $state,
            $stdOutLog;
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription( $description )
    {
        $this->description = $description;
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function setPid( $pid )
    {
        $this->pid = $pid;
    }

    public function getStdErrorLog()
    {
        return $this->stdErrorLog;
    }

    public function setStdErrorLog( $stdErrorLog )
    {
        $this->stdErrorLog = $stdErrorLog;
    }

    public function getStop()
    {
        return $this->stop;
    }

    public function setStop( $stop )
    {
        $this->stop = $stop;
    }

    public function getLogFile()
    {
        return $this->logFile;
    }

    public function setLogFile( $logFile )
    {
        $this->logFile = $logFile;
    }

    public function getExitStatus()
    {
        return $this->exitStatus;
    }

    public function setExitStatus( $exitStatus )
    {
        $this->exitStatus = $exitStatus;
    }

    public function getSpawnerr()
    {
        return $this->spawnerr;
    }

    public function setSpawnerr( $spawnerr )
    {
        $this->spawnerr = $spawnerr;
    }

    public function getNow()
    {
        return $this->now;
    }

    public function setNow( $now )
    {
        $this->now = $now;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup( $group )
    {
        $this->group = $group;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function getStatename()
    {
        return $this->statename;
    }

    public function setStatename( $statename )
    {
        $this->statename = $statename;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart( $start )
    {
        $this->start = $start;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState( $state )
    {
        $this->state = $state;
    }

    public function getStdOutLog()
    {
        return $this->stdOutLog;
    }

    public function setStdOutLog( $stdOutLog )
    {
        $this->stdOutLog = $stdOutLog;
    }
}