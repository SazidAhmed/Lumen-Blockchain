<?php

namespace App\Services;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ConstServices{
    public $name;
    public $color;
  
    public function __construct($name, $color) {
      $this->name = $name;
      $this->color = $color;
    }

    public function get_name() {
      return $this->name;
    }

    public function get_color() {
        return $this->color;
    }
}