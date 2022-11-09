<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\CallabcLog;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Handle calls to methods on controller serve data from request
     * 
     * @param object $request from object of request class only
     */
    public function __construct(Request $request)
    {
        $this->host = $request->host();
        $this->httphost = $request->httphost();
        $this->fullhostpath = $request->schemeAndHttpHost();
        $this->fullurl = $request->fullUrl();
        $this->uri = $request->path();
        $this->requestMethod = $request->method();
        $this->data = $request->input();
        $this->query = $request->query(); 
    }

    /**
     * Execute insert logs request from user
     * log
     *
     */
    public function logs() {
        $this->log = new CallabcLog;

        $this->log->url = $this->fullhostpath;
        $this->log->uri = $this->uri;
        $this->log->method = $this->requestMethod;
        $this->log->data = json_encode([
            'data' => $this->data,
            'querystring' => $this->query
        ]);

        return $this->log->save();
    }
}
