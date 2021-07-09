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

        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $controller->index();
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $controller->score();
        }
    }
}