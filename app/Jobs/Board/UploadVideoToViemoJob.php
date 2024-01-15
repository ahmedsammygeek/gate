<?php

namespace App\Jobs\Board;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Lesson;
use Vimeo;
use Log;
class UploadVideoToViemoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lesson;
    public $video_temp_path; 

    /**
     * Create a new job instance.
     */
    public function __construct($lesson , $video_temp_path )
    {
        $this->lesson = $lesson;
        $this->video_temp_path = $video_temp_path;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $video_path = Vimeo::upload(storage_path().'/app/public/'.$this->video_temp_path , [
            'privacy' => [
                'embed' => 'whitelist' , 
                'download' => false , 
                'view' => 'disable'
            ] , 
            'embed_domains' => [
                'localhost:8000' , 
                'https://thegatelearning.com/' ,
                'http://thegateacadmey.com/' ,
                'https://backend.thegatelearning.com' ,
                'https://facebook.com' ,
            ]
        ] );
        $this->lesson->vimeo_number = explode('videos/', $video_path)[1];
        $this->lesson->save();

        // Log::info($video_path);
        // $video = Vimeo::request($video_path, ['name' => $this->lesson->title_ar  , 'description' => $this->lesson->description_ar ], 'patch');


    }
}
