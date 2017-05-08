<?php
/**
 * Config File
 */

// Database
define('DB_DRIVER', 'mysql');
define('DB_HOST',   'localhost');
define('DB_NAME',   'QuantumAPI');
define('DB_USER',   'root');
define('DB_PWD' ,   '');

// API
define('DEBUG',                 true);              // If debug mode (Showing errors)
define('MAINTENANCE',           false);             // If under maintenance
define('DEFAULT_MODULE',        "Example");         // Default module to load if no route provided
define('SESSION_MAX_TIME',      1800);              // Max time for an user session
define('API_KEY',               ["4DECDA07CEE9",    // API Keys
                                 "6C3915A74912",
                                 "A96F8A2DD253"]);
