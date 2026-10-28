<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\JobImportController;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = public_path('Job Data for Web Upload.xlsx');

        if (!file_exists($filePath)) {
            dd('File not found');
        }

        $xlsFileData = Excel::toArray([], $filePath)[0];

        dd(count($xlsFileData));
        (new JobImportController())->importData($xlsFileData);
    }
}
