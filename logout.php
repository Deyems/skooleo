<?php
    require __DIR__."/settings.php";
    require APP_INCLUDE_PATH."/session_start.php";
    logout();
    header("Location: /");
