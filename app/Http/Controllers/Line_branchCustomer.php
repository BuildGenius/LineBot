<?php

namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\Code_Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class Line_branchCustomer extends BaseController
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->logs();
    }


    public function Get_Request()
    {
        try {
            // dd($this->data);
            $this->Validation_req();
            $txt_group = $this->Set_txt_group();
            $Message = $this->Set_Message($txt_group);
            $response = $this->API_SendLINEnoti($Message);
            return $response;
            dd($Message);
        } catch (Code_Exception $e) {
            return $e->Get_MessageError();
        }
    }


    public function Validation_req()
    {
        $validate = [
            'app_num',
            'name',
            'barch_id',
            'ck01',
            'rm01',
            'tax',
            'ck02',
            'rm02',
            'birthday',
            'ck03',
            'rm03',
            'phone',
            'ck05',
            'rm05',
            'social',
            'ck06',
            'rm06',
            'ck04',
            'rm04',
            'std_id',
            'ck07',
            'rm07',
            'university',
            'ck08',
            'rm08',
            'faculty',
            'ck10',
            'rm10',
            'level',
            'ck11',
            'rm11',
            'u_level',
            'ck12',
            'rm12',
            'barch',
            'status',
            'date',
            'rm_status'
        ];

        foreach ($validate as $key) {
            if (!isset($this->data[$key])) {
                return throw new Code_Exception('1000', 'Request parameter [' . $key . ']');
            }
        }
    }


    public function Get_Line_Token_Branch($branch_type)
    {
        $token_branch = [
            1 => [
                'token' => 'DCBppKZlonVA5QGBRWXznmRncqMrdU03k86CvZ00wme',
            ],
            2 => [
                'token' => 'gjB38Ty9OgwuwnV71rgV7fJ0hTzdJa3NpWH9PUwrP4p',
            ],
            3 => [
                'token' => 'fLQm8OzAfIQ14xOn2g7f9vRmeUK7biwDg7YObKdefoc',
            ],
        ];

        return $token_branch[$branch_type][0] ?? 'RqULZ7a2f8Ib415MgHeW9z2zirPcaMWosscXrEfwL6P';
    }


    public function Set_txt_group()
    {
        $arr_text = array();

        $text_name = $this->data['ck01'] == 'PASS'
            ? 'ชื่อ - นามสกุล :' . $this->data['name']
            : 'ชื่อ - นามสกุล : NOT PASS (' . $this->data['rm01'] . ')';
        array_push($arr_text, $text_name);

        $text_tax = $this->data['ck02'] == 'PASS'
            ? 'เลขบัตรประชาชน :' . $this->data['tax']
            : 'เลขบัตรประชาชน : NOT PASS (' . $this->data['rm02'] . ')';
        array_push($arr_text, $text_tax);

        $this->data['ck03'] != 'PASS' ?  array_push($arr_text, 'วันเกิด : NOT PASS (' . $this->data['rm03'] . ')') : null;

        $this->data['ck04'] != 'PASS' ?  array_push($arr_text, 'ข้อมูลที่อยู่ : NOT PASS (' . $this->data['rm04'] . ')') : null;

        $text_phone = $this->data['ck05'] == 'PASS'
            ? 'เบอร์โทรศัพท์ : ' . $this->data['phone']
            : 'เบอร์โทรศัพท์ : ' . $this->data['phone'] . ' NOT PASS (' . $this->data['rm05'] . ')';
        array_push($arr_text, $text_phone);

        $this->data['ck06'] != 'PASS' ?  array_push($arr_text, 'Facebook / IG name : NOT PASS (' . $this->data['rm06'] . ')') : null;

        $this->data['ck07'] != 'PASS' ?  array_push($arr_text, 'รหัสนักศึกษา : NOT PASS (' . $this->data['rm07'] . ')') : null;

        $this->data['ck08'] != 'PASS' ?  array_push($arr_text, 'ชื่อมหาวิทยาลัย : NOT PASS (' . $this->data['rm06'] . ')') : null;

        $this->data['ck10'] != 'PASS' ?  array_push($arr_text, 'คณะ : NOT PASS (' . $this->data['rm10'] . ')') : null;

        $this->data['ck11'] != 'PASS' ?  array_push($arr_text, 'ระดับการศึกษา : NOT PASS (' . $this->data['rm11'] . ')') : null;

        $this->data['ck12'] != 'PASS' ?  array_push($arr_text, 'ระดับการศึกษา : NOT PASS (' . $this->data['rm12'] . ')') : null;

        return $arr_text;
    }


    public function Set_Message($txtGroup)
    {
        $status = $this->data['status'];
        $barch = $this->data['barch'];
        $app_num = $this->data['app_num'];
        $name = $this->data['name'];
        $phone = $this->data['phone'];
        $date = $this->data['date'];
        $rm_status = $this->data['rm_status'];

        // set meg
        $header1 = 'รายการตรวจสอบข้อมูลผู้เช่าซื้อ';
        $header2 = 'ส่วนของสถาบัน';

        $message = '';
        if ($status == 'Approve') {
            $message = "\n" .
                'สถานะอนุมัติ : ' . $status . "\n" .
                '------------------------------' . "\n" .
                $header1 .  "\n" .
                'สาขา: ' . $barch . "\n" .
                'เลขที่ใบคำขอ: ' . $app_num . "\n" .
                '------------------------------' . "\n" .
                'ชื่อ - นามสกุล  ' . $name . "\n" .
                'เบอร์โทรศัพท์  : ' . $phone . "\n" .
                '------------------------------' . "\n" .
                '-- ข้อมูลพิจารณา --' . "\n" .
                'สถานะอนุมัติ : ' . $status . "\n" .
                'วันที่อนุมัติ :' . $date . "\n";
        } else if ($status == 'Reject') {
            $message = "\n" .
                'สถานะอนุมัติ : ' . $status . "\n" .
                '------------------------------' . "\n" .
                $header1 .  "\n" .
                'สาขา: ' . $barch . "\n" .
                'เลขที่ใบคำขอ: ' . $app_num . "\n" .
                '------------------------------' . "\n" .
                'ชื่อ - นามสกุล  ' . $name . "\n" .
                'เบอร์โทรศัพท์  : ' . $phone . "\n" .
                '------------------------------' . "\n" .
                '-- ข้อมูลพิจารณา --' . "\n" .
                'สถานะอนุมัติ : ' . $status . "\n" .
                'วันที่อนุมัติ :' . $date . "\n";
        } else if ($status == 'Rework') {
            $message = "\n" .
                'สถานะอนุมัติ : ' . $status . "\n" .
                '------------------------------' . "\n" .
                $header1 .  "\n" .
                'สาขา: ' . $barch . "\n" .
                'เลขที่ใบคำขอ: ' . $app_num . "\n" .

                '------------------------------' . "\n";
            foreach ($txtGroup as $value) {
                $message .= $value . "\n";
            };
            $message .=
                '-- ข้อมูลพิจารณา --' . "\n" .
                'สถานะอนุมัติ : ' . $status . "\n" .
                'วันที่อนุมัติ :' . $date . "\n" .
                'คำอธิบายเพิ่มเติม :' . $rm_status . "\n";
        }

        return $message;
    }


    public function API_SendLINEnoti($message)
    {
        try {

            $token = $this->Get_Line_Token_Branch($this->data['barch_id']);
            $response = Http::withHeaders([
                "content-type" => "application/x-www-form-urlencoded",
                "Authorization" => "Bearer {$token}",
            ])->post("https://notify-api.line.me/api/notify", [
                "message" => $message,
            ]);

            $Line_res = json_decode($response->body());

            return $Line_res;

        } catch (ConnectionException $e) {
            return $e;
        }
    }
}
