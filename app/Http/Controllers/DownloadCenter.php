<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use function Termwind\render;

class DownloadCenter extends Controller {
    function __construct()
    {
        $this->PublicPath = public_path() . '\\storages';
        $this->is_directory = false;
        $this->folders = [];
        $this->files = [];
    }
    // public function DownloadCenter (Request $request) {
    //     var_dump($request->query);
    //     return view('downloads');
    // }
    public function getDownloadFolder ($path = '', $subpath = '') {
        $this->Exists_directory($this->PublicPath . "\\{$path}" . "\\{$subpath}")
        ->read_directory();

        return view('downloads', ["path" => explode("/", $this->PublicPath), "files" => ['files' => $this->files, 'folders' => $this->folders]]);
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

            for ($i = 2;$i < count($files);$i++) {
                preg_match('/[a-zA-Z0-9]+[.][a-zA-Z]+/m', $files[$i], $matches);

                if (count($matches) > 0) {
                    array_push($this->files, $files[$i]);
                } else {
                    array_push($this->folders, $files[$i]);
                }
            }
        }

        return $this;
    }
}
