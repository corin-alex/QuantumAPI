<?php
/**
 * Config File
 */

// Database
define('DB_DRIVER', 'mysql');
define('DB_HOST',   'localhost');
define('DB_NAME',   'QuantumAPI');
define('DB_USER',   'root');
define('DB_PWD' ,   'root');

// API
define('DEBUG',                 true);              // If debug mode (Showing errors)
define('MAINTENANCE',           false);             // If under maintenance
define('DEFAULT_MODULE',        "Index");           // Default module to load if no route provided
define('SESSION_MAX_TIME',      1800);              // Max time for an user session
define('API_KEY_CHECK',         false);             // Validate api key provided by the client
