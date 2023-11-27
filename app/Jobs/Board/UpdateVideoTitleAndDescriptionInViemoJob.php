<?php

namespace App\Jobs\Board;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vimeo;
use Log;
class UpdateVideoTitleAndDescriptionInViemoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lesson;

    /**
     * Create a new job instance.
     */
    public function __construct($lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Vimeo::request("/videos/".$this->lesson->vimeo_number, ['name' => $this->lesson->title  , 'description' => $this->lesson->description ], 'patch');
    }
}
