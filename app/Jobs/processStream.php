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
        $this->uploadsDir = public_path('storage') . '/' . $input['series'] . '/' . $input['season'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //The path & filename to save to.
        $saveTo = $this->uploadsDir . '/' . Str::uuid() . '.mp4';

        $output = shell_exec("wget '".$this->upload."' -O '".$saveTo."' 2>&1");

        if ($output) {
            $this->stream->update([
                'url' => $saveTo
            ]);
        }

        //Open file handler.
        // $fp = fopen($saveTo, 'w+');

        // //If $fp is FALSE, something went wrong.
        // if ($fp === false) {
        //     Log::debug('Could not open: '.$saveTo);
        // }
        
        // //Create a cURL handle.
        // $ch = curl_init($this->upload);

        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: curl/7.39.0');
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        

        // //Pass our file handle to cURL.
        // curl_setopt($ch, CURLOPT_FILE, $fp);

        // //Timeout if the file doesn't download after 8mins.
        // curl_setopt($ch, CURLOPT_TIMEOUT, 480);

        // //Execute the request.
        // curl_exec($ch);

        // //If there was an error, throw an Exception
        // if (curl_errno($ch)) {
        //     Log::debug(curl_error($ch));
        // }

        // //Get the HTTP status code.
        // $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $statusText = curl_getinfo($ch);

        // //Close the cURL handler.
        // curl_close($ch);

        // //Close the file handler.
        // fclose($fp);

        // if ($statusCode == 200) {
        //     $this->stream->update([
        //         'url' => $saveTo
        //     ]);
        // } else {
        //     echo "<pre>";
        //     echo var_dump($statusText);
        //     echo "</pre>";
        //     echo "Status Code: ".$statusCode;
        // }


    }
}
