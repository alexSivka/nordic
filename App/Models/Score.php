<?php
/**
 * simple model
 */

namespace App\Models;

class Score {

    protected array $data = [
        'family' => '',
        'name' => '',
        'surname' => '',
        'sex' => 0,
        'birthday' => '',
        'children' => 0,
        'marital' => 0,
        'salary' => 0,
        'employment' => 0,
        'real_estate' => 0,
        'credit' => 0,
        'debt' => 0,
        'credit_price' => 0,
        'age' => 0
    ];

    protected array $validateRules = [
        'family' => 'emptyValidate',
        'name' => 'emptyValidate',
        'surname' => 'emptyValidate',
        'birthday' => 'birthdayValidate'
    ];

    public array $errors = [];

    public array $scores = [];

    function __construct($input = [])
    {
        foreach ($input as $key => $value) {
            if(isset($this->data[ $key ])) $this->data[ $key ] = trim($value);
        }
        $this->data['age'] = $this->data['birthday'] ? date('Y') - date('Y', strtotime($this->data['birthday'])) : 0;
        $this->setScores();
    }

    public function setScores(): void
    {
        $this->scores = [
            fn() => $this->age < 18 ? 5 : 0,
            fn() => $this->age > 30 && $this->sex == 1 && $this->salary < 25000 && $this->marital == 0 && $this->children == 0 ? 2 : 0,
            fn() => $this->age > 30 && $this->sex == 1 && $this->salary < 30000 && $this->marital == 0 && $this->children > 0 ? 3 : 0,
            fn() => $this->age > 26 && $this->sex == 0 && $this->salary < 22000 && $this->marital == 0 && $this->children == 0 ? 2 : 0,
            fn() => $this->age > 26 && $this->sex == 0 && $this->salary < 28000 && $this->marital == 0 && $this->children > 2 ? 3 : 0,
            fn() => $this->age > 65 && $this->debt && $this->employment == 0 ? 3 : 0,
            fn() => $this->debt && $this->credit_price > ($this->salary / 2) ? 3 : 0,
            fn() => $this->age > 17 && $this->salary < 15000 ? 2 : 0,
            fn() => $this->age > 17 && $this->age < 36 && $this->children == 1 ? 1 : 0,
            fn() => $this->age > 17 && $this->age < 36 && $this->children > 1 ? 2 : 0,
        ];
    }

    public function check() :int
    {
        $score = 0;
        foreach ($this->scores as $func) {
            $score += $func();
        }
        return $score;
    }

    // inputs simple validation

    public function validate() :array
    {
        foreach ($this->validateRules as $key => $method) {
            if (!$this->$method($this->data[ $key ])) {
                $this->errors[] = $key;
            }
        }
        return $this->errors;
    }

    private function emptyValidate($value) :bool {
        return $value !== '';
    }

    private function birthdayValidate($value) :bool {
        $start = date('Ymd', strtotime('-65 year'));
        $end = date('Ymd', strtotime('-14 year'));
        $input = date('Ymd', strtotime($value));
        return preg_match('~\d{4}-\d{2}-\d{2}~', $value) && $input >= $start && $input <= $end;
    }

    function __get($key)
    {
        return $this->data[ $key ] ?? null;
    }

    function all() :array {
        return $this->data;
    }
}