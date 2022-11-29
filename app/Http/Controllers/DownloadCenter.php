<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use function Termwind\render;

class DownloadCenter extends Controller {
    function __construct(Request $request)
    {
        PARENT::__construct($request);
    }

    public function downloadFile() {
        return response()->download(public_path() . $this->query['path']);
    }
}
