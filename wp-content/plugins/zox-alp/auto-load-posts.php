<?php
/*
Plugin Name: Zox Auto Load Posts
Description: Zox Auto Load Posts
Author: MVPThemes
Author https://themeforest.net/user/mvpthemes/portfolio
Version: 1.0
*/

require_once(__DIR__ . '/config.php');
$Plugin = new \AutoLoadPosts\Plugin();
$Plugin->Init();