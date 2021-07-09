<?php
/**
 * Самый простой роутер
 */

namespace App\Components;

use App\Controllers\SiteController;

class Router {
    public function run()
    {
        $controller = new SiteController();
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        if($method == 'GET') {
            $controller->index();
        }

        if($method == 'POST') {
            $controller->score();
        }
    }
}