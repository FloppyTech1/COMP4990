<?php

    // Run installer for composer
    exec('php composer.phar install', $output, $return);
    if ($return !== 0) {
        echo "Composer installation failed!";
    } else {
        echo "Composer dependencies installed successfully!";
    }
?>