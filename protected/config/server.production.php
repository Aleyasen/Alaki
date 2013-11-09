<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    // application components
    'components' => array(
        'facebook' => array(
            'appId' => '262751097206670', // needed for JS SDK, Social Plugins and PHP SDK
            'secret' => '3c43aaac31828cb10173de945c49d2cd', // needed for the PHP SDK 
        ),
        
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=CDA',
            'username' => 'root',
            'password' => 'hello',
        ),
    ),
);