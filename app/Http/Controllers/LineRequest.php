<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class LineRequest extends BaseController {
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->logs();
    }

    function keepRequest () {
        // $response = [];
        // if (isset($this->data->destination)&&!isset($this->data->events)) {
        //     $response = 'is test completed';
        // } else {
            $this->db = DB::connection('sqlsrvPRD');
            $index_fragmentation = $this->db->select($this->db->raw("EXEC [dbo].[SP_CHK_FRAGMENTATION_IN_PERCENT]"));
            for ($i = 0;$i < count($index_fragmentation);$i++) {
                $str = "Index Fragmentation"."  
" . $index_fragmentation[$i]->want_to ."  
" . $index_fragmentation[$i]->tablename;
                $this->fire($str);
            }
        // }
        
        return response()->json(['message' => 'OK!']);
    }

    function fire($text) {
        $testUser = "Uc2bf613d5e72898ae2547901f4cde1f1";
        $HttpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('LINE_ACCESS_TOKEN'));
        $client = new \LINE\LINEBot($HttpClient, ['channelSecret' => env('LINE_CHANEL_SECRET')]);

        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $response = $client->pushMessage($testUser, $textMessageBuilder);

        return $response->getHTTPstatus() . ' ' . $response->getRawBody();
    }
}