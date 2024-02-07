<?php

namespace App\Jobs;

use App\Helpers\General;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FileUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $file;
    protected $sub_directory;
    protected $model;
    protected $id;
    public function __construct($my_file, $my_sub_directory, $my_model, $my_id)
    {
        $this->file = $my_file;
        $this->sub_directory = $my_sub_directory;
        $this->model = $my_model;
        $this->id = $my_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $result = General::store_file($this->file, $this->sub_directory);
            if ($result['file_name'] != null) {
                switch ($this->model) {
                    case 'product':
                        Product::query()->find($this->id)->update([
                            'image' => $result['file_name']
                        ]);
                        break;
                    case 'user':
                        User::query()->find($this->id)->update([
                            'image' => $result['file_name']
                        ]);
                        break;

                    default:
                        # code...
                        break;
                }
            }
        } catch (\Throwable $th) {
            Log::channel('file_upload')->error("\nERROR MESSAGE: " . $th->getMessage());
        }
    }
}
