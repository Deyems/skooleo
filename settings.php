<?php
define('__INCLUDED__',true);

/** PATH */
define('APP_PATH', __DIR__);
define('APP_LIB_PATH', __DIR__.'/lib');
define('APP_INCLUDE_PATH', __DIR__.'/includes');

/**
 * Database config
 */
//If we didn't change the default PORT for mysql
// You can leave that localhost as that 
// But if you have changed it -> Better to use
// localhost:PORT_NO -> localhost:8800;
define('DB_HOST', 'localhost:3306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'skooleo');

define('APP_KEY', 'ddkeoe393939fdifdj937hs93fs');
// define('APP_KEY', '');

require APP_LIB_PATH. '/functions.php';
require APP_LIB_PATH. '/db/mysql.php';
