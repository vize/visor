PHP daemon manager
========================================================================

In development, feel free to add Issues or send Pull Requests

This library is based on https://github.com/vize/supervisord

Install
--------

    sh install.sh

Example Usage
-------------

    use \Visor\Visor;

    // Attach Visor to a running supervisord server
    $visor = new Visor( '127.0.0.1:9900/RPC2' );
    
    // Create a new process group and run 1 instance
    $group = $visor->create( 'syslog', 'tail -f /var/log/syslog' )->run( 1 );
    
    // Scale up to 5 instances
    $group->run( 5 );

Tests
--------

    phpunit

Travis CI
---------

![travis-ci](http://cdn-ak.favicon.st-hatena.com/?url=http%3A%2F%2Fabout.travis-ci.org%2F)&nbsp;http://travis-ci.org/#!/vize/visor

![travis-ci](https://secure.travis-ci.org/vize/visor.png?branch=master)

License
------------------------

Released under the MIT(Poetic) Software license

    This work 'as-is' we provide.
    No warranty express or implied.
    Therefore, no claim on us will abide.
    Liability for damages denied.

    Permission is granted hereby,
    to copy, share, and modify.
    Use as is fit,
    free or for profit.
    These rights, on this notice, rely.
