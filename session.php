<?php

function loadIndexSession()
{
    session_start();
    if (
        isset($_SESSION['actor']['first_name']) &&
        isset($_SESSION['actor']['last_name']) &&
        isset($_SESSION['actor']['id'])
    ) {
        $page_title = "Welcome {$_SESSION['actor']['first_name']}";
        include('includes/loggedin_header.html');

        echo "You are now logged in, {$_SESSION['actor']['first_name']} {$_SESSION['actor']['last_name']}";

        if ($_SESSION['actor']['is_tradesman'] == 1) {

            echo '<a href="view_tradesmen_profile.php">
        <input class="css-input-btn-login" type="submit" value="View Profile"/>
        </a>';

        } else if (
            isset($_SESSION['actor']) && (
                $_SESSION['actor']['is_tradesman'] == 0
                && $_SESSION['actor']['first_name'] == "admin"
                && $_SESSION['actor']['last_name'] == "admin")
        ) {
            include_once("login_tools.php");
            load("admin_view.php");
        }

    } else {
        include('includes/header.html');

    }


}

function loadUpdatePermissions()
{
    session_start();
    if (
        isset($_SESSION['actor']['first_name']) &&
        isset($_SESSION['actor']['last_name']) &&
        isset($_SESSION['actor']['id'])
    ) {

        $page_title = "Welcome {$_SESSION['actor']['first_name']}";
        include('includes/loggedin_header.html');

        echo "You are now logged in, {$_SESSION['actor']['first_name']} {$_SESSION['actor']['last_name']}";
        if (($_SESSION['actor']['is_tradesman'] == 0)) {
            include_once('login_tools.php');
            load("index.php");
            return;
        }

    } else {
        include('includes/header.html');
        include_once('login_tools.php');
        load();
    }
}

function loadViewProfilePermission()
{

    session_start();
    if (
        isset($_SESSION['actor']['first_name']) &&
        isset($_SESSION['actor']['last_name']) &&
        isset($_SESSION['actor']['id'])
    ) {
        $page_title = "Welcome {$_SESSION['actor']['first_name']}";
        include('includes/loggedin_header.html');

        echo "You are now logged in, {$_SESSION['actor']['first_name']} {$_SESSION['actor']['last_name']}";
        if (($_SESSION['actor']['is_tradesman'] == 0) && (!isset($_POST['view-id']))) {
            require_once('login_tools.php');
            load("index.php");
        }

    } else {
        include('includes/header.html');
        require('login_tools.php');
        load();

    }
}

function loadAdminPermissions()
{
    session_start();
    if (
        isset($_SESSION['actor']) && (
            $_SESSION['actor']['is_tradesman'] == 0
            && $_SESSION['actor']['first_name'] == "admin"
            && $_SESSION['actor']['last_name'] == "admin")
    ) {
        $page_title = "Welcome {$_SESSION['actor']['first_name']}";
        include('includes/loggedin_header.html');

        echo "You are now logged in, {$_SESSION['actor']['first_name']}";

    } else {
        include('includes/header.html');
        include_once("login_tools.php");
        load("index.php");

    }

}
function loadSearchPermissions()
{
    session_start();
    if (
        isset($_SESSION['actor']['first_name']) &&
        isset($_SESSION['actor']['last_name']) &&
        isset($_SESSION['actor']['id'])
    ) {
        $page_title = "Welcome {$_SESSION['actor']['first_name']}";
        include('includes/loggedin_header.html');

        echo "You are now logged in, {$_SESSION['actor']['first_name']} {$_SESSION['actor']['last_name']}";

    } else {
        include('includes/header.html');
        include_once("login_tools.php");
        load("index.php");

    }
}
?>