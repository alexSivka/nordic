<?php

namespace App\Controllers;

use App\Models\Score;

class SiteController {
    public function index()
    {
        $score = new Score();
        $values = $score->all();
        $errors = $totalScore = $showScore = $scoreResult = 0;
        require_once ROOT . '/views/default.php';
    }

    public function score()
    {
        $score = new Score($_POST);

        $errors = $score->validate();
        $totalScore = $score->check();
        $scoreResult = $totalScore > 4 ? false : true;
        $showScore = !$errors;

        $values = $score->all();
        require_once ROOT . '/views/default.php';
    }
}