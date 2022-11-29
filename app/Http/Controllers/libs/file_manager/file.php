<?php

namespace App\Http\Controllers\libs\file_manager;

class file {
    public function __construct($path)
    {
        $this->path = $path;
        $this->pathstatus = false;
        $this->directory = new directory();
        $this->realPath = $this->directory->setPath($this->path)->checkPathFile()->forceCreate(true)->getPathFile();
    }

    function setter($key, $value) {
        $this->$key = $value;
        return $this;
    }

    function getter($key) {
        return $this->$key;
    }

    public function checkFileExists() {

    }

    public function setPathFile($path) {
        $this->setter('path', $path);
        return $this;
    }

    public function setFileType($filename) {
        $this->setter('filename', $filename);
        return $this;
    }

    public function setFileName($filetype) {
        $this->setter('filetype', $filetype);
        return $this;
    }

    public function createFile($data) {

    }

    public function createExcelFile($data, $filename, $filetype = 'xlsx') {
        $this->excel = new excel($filename, $filetype);
        $this->excel->setData($data);
        $this->excel->createFile();
        
        return $this->excel->getPathFile() . '.' . $filetype;
    }

    public function getPath() {
        return $this->getter('path');
    }
}