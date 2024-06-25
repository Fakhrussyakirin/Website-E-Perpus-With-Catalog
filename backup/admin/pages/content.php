<?php
if (!empty($_GET["module"])) {
    $module_file = $_GET["module"] . ".php";
    if (file_exists($module_file)) {
        include_once($module_file);
    } else {
        // Modul tidak ditemukan, tampilkan informasi untuk debugging
        echo "File not found: $module_file";
        if (file_exists("pages/views/v_404.php")) {
            echo "<br>v_404.php exists";
        } else {
            echo "<br>v_404.php does not exist";
        }
    }
} else {
    include "dashboard.php";
}
