<?php

namespace App\Jobs\Board;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;
use File;
class DeleteLocalVideoAfterUploadToViemoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video_temp_path; 
    /**
     * Create a new job instance.
     */
    public function __construct($video_temp_path)
    {
         $this->video_temp_path = $video_temp_path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // delete the local file
        Storage::delete([$this->video_temp_path]);
        // delete the folder
        $exploded_data = explode('/', $this->video_temp_path);
        File::deleteDirectory(storage_path().'/app/public/tmp_videos/'.$exploded_data[2]);
    }
}
