<?php

namespace Supervisord;

interface Connection
{
    public function call( $method, $params = array() );
}