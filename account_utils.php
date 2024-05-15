<?php

function sec_session_start() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        $session_name = 'picsel_session';
        $secure = false;
        $httponly = true;
        ini_set('session.use_only_cookies', 1);
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], 
                                $cookieParams['domain'], $secure, $httponly);
        session_name($session_name);
        session_start();
        session_regenerate_id();
    }
}

function isLoggedIn() {
    return !empty($_SESSION['user_id']);
}
?>