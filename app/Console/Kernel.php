<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\LineRequest;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function (Request $request) {
            $line = new LineRequest($request);
            $line->db = DB::connection('sqlsrvPRD');
            $index_fragmentation = $line->db->select($line->db->raw("EXEC [dbo].SP_CHK_FRAGMENTATION_IN_PERCENT"));

            for ($i = 0;$i < count($index_fragmentation);$i++) {
                $str = "Index Fragmentation"."  
" . $index_fragmentation[$i]->want_to ."  
" . $index_fragmentation[$i]->tablename;
                $line->fire($str);
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
