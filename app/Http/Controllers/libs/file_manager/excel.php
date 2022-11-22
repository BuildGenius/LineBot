<?php

namespace App\Http\Controllers\libs\file_manager;
use Spatie\SimpleExcel\SimpleExcelWriter;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use OpenSpout\Common\Entity\Style\Color;

class excel {
    function __construct($path = '')
    {
        $this->path = $path;
        $this->header = [];
        $this->data = [];
        $this->filetype = 'xlsx';
    }
    
    function setter($key, $value) {
        $this->$key = $value;
        return $key;
    }

    function getter($key) {
        return $this->$key;
    }

    public function setPath($path) {
        $this->setter('path', $path);
        return $this;
    }

    public function setFileType($filetype) {
        $this->setter('filetype', $filetype);
        return $this;
    }

    public function setfilename($filename = '') {
        $this->setter('filename', $filename);
        return $this;
    }

    public function setHeader($arrHeader) {
        $this->setter('header', $arrHeader);
        return $this;
    }

    public function setData($data) {
        $this->setter('data', $data);
        return $this;
    }

    public function setProperty() {

    }

    public function getPathFile() {
        return $this->getter('path');
    }

    public function CreateFile($filetype = '') {
        if ($filetype != '') {
            $this->setFileType($filetype);
        }

        $file = SimpleExcelWriter::create($this->path . '.' . $this->filetype, $this->filetype);

        for ($i = 0;$i < count($this->data);$i++) {
            $file->addRow((array) $this->data[$i]);
        }

        $this->setPath($file->getPath());

        return $this;
    }
}
