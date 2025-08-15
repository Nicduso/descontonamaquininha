<?php
define('ENVIRONMENT', 'local');

define('DB_LOCAL', __DIR__ . '/ConnectionLocal.class.php');
define('DB_AWS', __DIR__ . '/Connection.class.php');

if (ENVIRONMENT == 'local') {
	require_once DB_LOCAL;
} else {
	require_once DB_AWS;
}
