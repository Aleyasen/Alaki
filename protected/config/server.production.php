<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    // application components
    'components' => array(
        'facebook' => array(
            'appId' => '114506072034684', // needed for JS SDK, Social Plugins and PHP SDK
            'secret' => '5115719c31e161cc3b7f26186ada481b', // needed for the PHP SDK 
        ),
        
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=CDA',
            'username' => 'root',
            'password' => 'hello',
        ),
    ),
);