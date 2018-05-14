<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

echo session_status()." | ".PHP_SESSION_NONE." ?";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo " OK";
}
else{
    echo " FAIL";
}
die();
?>