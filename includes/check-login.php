<!-- Check login -->
<?php

require_once __DIR__.'/functions.php';
require_once __DIR__.'/../classes/User.php';


if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['userid'])) {
        $user_id = (int)$_COOKIE['userid'];

        $users = loadUsers(__DIR__.'/../data/users.json');

        $found_user = null;

        foreach ($users as $user) {
            if ($user->id === $user_id) {
                $found_user = $user;
                break;
            }
        }

        if ($found_user) {
            $_SESSION['user_id'] = $found_user->id;
            $_SESSION['name'] = $found_user->name;

            return;
        }
    }

    header('Location: login-required.php');
    exit;
}
?>
