<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use App\Models\Stream;
use Illuminate\Support\Facades\Storage;

class processStream implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uploadsDir;
    protected $upload;
    protected $stream;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $input)
    {
        $this->stream = $input['stream'];
        $this->upload = $input['episode_url'];
        $this->uploadsDir = $input['storage_dir'];
        $this->fileDir  = $input['file_dir'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //The path & filename to save to.
        $fileName = Str::uuid() . '.mp4';
        $saveTo = $this->uploadsDir;

        $path = Storage::disk('local')->makeDirectory($saveTo);

        $file =  $this->upload;
            $cmd = 'curl "'.$file.'" -o "'.$path.'"';
            $output = shell_exec($cmd);
        
        if ($output) {
            $this->stream->update([
                'url' => $fileDir . $fileName 
            ]);
        } 
    }
}
