<?php
    require __DIR__."/session_start.php";
    require __DIR__."/settings.php";
    logout();
    header("Location: /");
