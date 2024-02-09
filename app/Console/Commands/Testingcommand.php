<?php

namespace App\Console\Commands;

use App\Helpers\General;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Testingcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testing:command';
    // protected $signature = 'testing:command {--name=} {phone_number}';

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
        $items = [];
        // $name = $this->option('name');
        // $phone = $this->argument('phone_number');
        // Log::info("\nNAME: " . $name . "\nPHONE NUMBER: " . $phone);
        $result = General::read_excel_file(7);
        if ($result['success']) {
            foreach ($result['names'] as $item) {
                array_push($items, $item);
            }
            echo json_encode($items);
        } else {
            $this->error($result['message']);
        }
    }
}
