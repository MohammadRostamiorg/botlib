<?php

function loadEnv() {

    $envPath = dirname(__DIR__."../")."/.env";
    // Read the file line by line
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Remove comments and whitespace
        $line = trim(preg_replace('/\s*#.*$/', '', $line));

        if (!empty($line) && $line[0] != ";") {
            // Split the line by the first equals sign
            list($key, $value) = explode('=', $line, 2);
            // Trim whitespace from key and value
            $key = trim($key);
            $value = trim($value);
            // Set the environment variable
            putenv("$key=$value");
            // Optionally, set it in $_ENV or $_SERVER
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value; // If needed
        }
    }

}
loadEnv();