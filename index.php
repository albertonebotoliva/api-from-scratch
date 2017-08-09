<?php
/*
  Set up Micro-framework M*C environment

  Functions:
    - system_autoload       - Loads the existing files
    - initializeEnvironment - Define path and autoload
    - start

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/

function system_autoload( $class_name )
{
    // Convert class name to filename format.
    $class_name = strtolower( $class_name );
    $paths = array(
        CONTROLLER_PATH,
        MODEL_PATH,
        LIB_PATH
      );

    // Search the files
    foreach( $paths as $path ) {
        if( file_exists( "$path/$class_name.php" ) )
            require_once( "$path/$class_name.php" );
    }
}

function initializeEnvironment(){
  define( 'PATH', dirname( __FILE__ ) );
  // MVC PATHs
  define( 'CONTROLLER_PATH',  PATH . '/controllers' );
  define( 'MODEL_PATH',       PATH . '/models' );
  define( 'LIB_PATH',         PATH . '/libs' );
  //Autoload the system.
  spl_autoload_register( 'system_autoload' );
}

function start(){
  $API = new API();
  $API->run();
}

initializeEnvironment();
start();
