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

        //Open file handler.
        $fp = fopen($saveTo, 'w+');

        // //If $fp is FALSE, something went wrong.
        if ($fp === false) {
            Log::debug('Could not open: '.$saveTo);
        }
        
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->upload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEMOUT => 480,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOM_METHOD => "GET"
        ));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            Log::debug(curl_error($ch));
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $statusText = curl_getinfo($ch);

        curl_close($ch);


        if ($statusCode == 200) {
            $this->stream->update([
                'url' => $saveTo
            ]);
        } else {
            echo "<pre>";
            echo "---------";
            echo "---------";
            echo $response;
            echo "---------";
            echo "---------";
            echo var_dump($statusText);
            echo "</pre>";
            echo "Status Code: ".$statusCode;
        }

    }
}
