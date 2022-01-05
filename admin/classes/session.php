<?php

class Session {
    public function start()
    {
        session_start();
    }

    // save session data
    public function send($user)
    {
        $_SESSION['user'] = $user;
    }

    // get session data
    public function get()
    {
        if(isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }
        else {
            $user = '';
        }
        return $user;
    }

    public function destroy()
    {
        session_destroy();
    }
}
?>