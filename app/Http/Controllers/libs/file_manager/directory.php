<?php

namespace App\Http\Controllers\libs\file_manager;

class directory {
    function __construct()
    {
        $this->path = "";
        $this->stPath = true;
        $this->stCreate = "";
        $this->forceCreate = true;
    }

    function setter ($key, $value) {
        $this->$key = $value;
        return $this;
    }

    function getter ($key) {
        return $this->$key;
    }

    public function setPath($value) {
        $this->setter('path', $value);
        return $this;
    }

    public function checkPathFile() {
        if (!is_dir($this->path)) {
            $this->stPath = false;
        }

        return $this;
    }

    public function setForce($value) {
        $this->setter('force', $value);
        return $this;
    }

    public function Create() {
        if (!$this->stPath&&$this->force) {
            $this->stCreate = mkdir($this->path);
        }
        return $this;
    }

    public function forceCreate($force) {
        $this->setForce($force);

        if ($this->force) {
            $this->checkPathFile()->Create();
        }
        
        return $this;
    }

    public function getPathFile() {
        return $this->getter('path');
    }
}