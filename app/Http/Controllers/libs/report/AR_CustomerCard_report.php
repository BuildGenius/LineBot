<?php

namespace App\Http\Controllers\libs\report;

use App\Http\Controllers\libs\file_manager\file;
use App\Http\Controllers\libs\file_manager\excel;
use DateTime;
use Illuminate\Support\Facades\DB;

class AR_CustomerCard_report {
    public function __construct()
    {
        $d = new DateTime();
        $this->stored_procedure = '[dbo].[SP_REPORT_CUSTOMER_CARD_DATA_MONTHLY]';
        $this->param_year = $d->format('Y');
        $this->param_month = $d->format('m');
        $this->file = new file(public_path() . '\\storages\\file\\report');
        $this->filename = "report_CustCard_{$this->param_month}{$this->param_year}";

        $this->sendto = 'Uc2bf613d5e72898ae2547901f4cde1f1';
        $this->text = `ขออนุญาตินำส่งรายงาน ar Customer Card นะครับ\r\n`;
    }

    public function CreateReport () {
        $this->db = DB::connection('sqlsrvPRD');

        $this->report = $this->db->select(
            $this->db->raw("EXEC {$this->stored_procedure} @year = {$this->param_year},@month = {$this->param_month};")
        );

        $path = $this->file->createExcelFile($this->report, $this->file->getPath() . '\\' . $this->filename);
        
        return response()->json($path);
    }
}