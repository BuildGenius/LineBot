<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use function Termwind\render;

class DownloadCenter extends Controller {
    function __construct()
    {
        $this->downloadPath = public_path() . '/storages';
        $this->reportPath = public_path() . '/storages/file/report';
        $this->is_directory = false;
        $this->folders = [];
        $this->files = [];
    }
    // public function DownloadCenter (Request $request) {
    //     var_dump($request->query);
    //     return view('downloads');
    // }
    public function getDownloadFolder () {
        $this->Exists_directory($this->downloadPath)
        ->read_directory();
        var_dump($this->files, $this->folders);

        return view('downloads', ["path" => explode("/", $this->downloadPath), "files" => [$this->files, $this->folders]]);
    }

    function Exists_directory($uri) {
        if (is_dir($uri)) {
            $this->onNowHere = $uri;
            $this->is_directory = true;
        }

        return $this;
    }

    function read_directory() {
        if ($this->is_directory) {
            $files = scandir($this->onNowHere, 0);

            for ($i = 0;$i < count($files);$i++) {
                var_dump($files[$i]);
                // preg_match_all('/./', $files, $matches, PREG_SET_ORDER, 0);
                // if ($matches > 0) {
                //     array_push($files, $this->files);
                // } else {
                //     array_push($files, $this->folders);
                // }
            }
        }

        return $this;
    }
}
