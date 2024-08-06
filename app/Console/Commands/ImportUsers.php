<?php

namespace App\Console\Commands;

// use Dotenv\Store\File\Reader as FileReader;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from a CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file) || !is_readable($file)) {
            $this->error('CSV file does not exist or is not readable.');
            return;
        }

        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);


        $stmt = (new Statement())
            ->offset(0)
            ->limit(1000); // Adjust the chunk size as needed (.xlsx)

        $records = $stmt->process($csv);

        $batchSize = 1000; // Number of records to insert per batch
        $batch = [];

        foreach ($records as $record) {

            $batch[] = [
                'name' => $record['name'],
                'email' => $record['email'],
                'phone' => $record['phone'],
                'password' => Hash::make($record['phone']),
            ];

            if (count($batch) >= $batchSize) {
                DB::table('users')->insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('users')->insert($batch);
        }

        $this->info('Users imported successfully.');
    }
}
