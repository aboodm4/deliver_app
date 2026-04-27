<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessProductUpload implements ShouldQueue
{
    use Queueable;

    protected $filePath;
    protected $storeId;

    public function __construct($filePath, $storeId)
    {
        $this->filePath = $filePath;
        $this->storeId = $storeId;
    }


    public function handle(): void
    {
        Log::info("Starting bulk product upload for store ID: {$this->storeId}");
        if (!file_exists($this->filePath)) {
            Log::error("File not found: {$this->filePath}");
            return;
        }

        if (($handle = fopen($this->filePath, "r")) !== FALSE) {
            fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                  Product::create([
                    'name' => $data[0] ?? 'New Product',
                    'description' => $data[1] ?? null,
                    'price' => $data[2] ?? '0',
                    'quantity' => $data[3] ?? '0',
                    'arname' => $data[4] ?? null,
                    'ardescription' => $data[5] ?? null,
                    'store_id' => $this->storeId,
                    'rate' => '5'
                ]);
            }
            fclose($handle);
            unlink($this->filePath);
        }

        Log::info("Bulk product upload completed successfully.");
    }
}
