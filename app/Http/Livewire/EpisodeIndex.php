<?php

namespace App\Http\Livewire;

use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use App\Models\StreamUrl;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class EpisodeIndex extends Component
{


    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    public $episode;
    public $episode_dir;
    public $url;
    public $episodeNumber;
    public $episodeId;
    public $showEpisodeModal = false;

    protected $rules = [
        'episodeNumber' => 'required|numeric'
    ];

    public function mount(Series $series, Season $season) {
        $this->series = $series;
        $this->season = $season;

    }

    public function createEpisode()
    {
        $episode = Episode::create([
            'season_id' => $this->season->id,
            'episode_number' => $this->episodeNumber
        ]);


        $seriesDir = $this->slugify($this->series->name);
        
        $this->createDirectory([$seriesDir]);


        $seasonDir = $this->slugify($this->season->season_number);
        $this->createDirectory([$seriesDir, $seasonDir]);

        $streamId = $episode->stream()->create([
            'url' => $this->url
        ]);

        $data[] = 
            [
                'stream' => $stream,
                'episode_url' => $this->url,
                'series' => $seriesDir,
                'season' => $seasonDir
            ];

        $uploadsJobs = new ProcessUploads($data);
        $this->dispatch($uploadsJobs);

        $this->reset(['episodeNumber', 'url']);

        if ($episode) {
            $this->dispatchBrowserEvent('banner-style', [
                'style' => 'success',
                'message' => 'Episode created'
            ]);
        } else {
            $this->dispatchBrowserEvent('banner-style', [
                'style' => 'danger',
                'message' => 'Episode already exists'
            ]);
        }
    }

    public function showEditModal($id)
    {
        $this->episodeId = $id;
        $this->loadEpisode();
        $this->showEpisodeModal = true;
    }

    public function loadEpisode()
    {
        $episode = Episode::findOrFail($this->episodeId);
        $this->episodeNumber = $episode->episode_number;
        $this->url = $episode->stream->url;
    }

    public function closeEpisodeModal()
    {
        $this->showEpisodeModal = false;
    }

    public function updateEpisode()
    {
        $this->validate();

        $episode = Episode::findOrFail($this->episodeId);
        $episode->update([
            'episode_number' => $this->episodeNumber,
        ]);

        $episode->stream()->update([
            'url' => $this->url
        ]);


        $this->dispatchBrowserEvent('banner-style', [
            'style' => 'success',
            'message' => 'Episode updated'
        ]);

        $this->reset(['url', 'episodeNumber', 'showEpisodeModal']);
    }

    public function deleteEpisode($id)
    {
        $episode = Episode::findOrFail($id);
        $episode->delete();
        $this->reset(['episodeNumber', 'episodeId', 'showEpisodeModal']);   

        $this->dispatchBrowserEvent('banner-style', [
            'style' => 'success',
            'message' => 'Episode deleted'
        ]);
    }

    public function deleteStream($streamId)
    {
        $stream_url = StreamUrl::findOrFail($streamId);
        $stream_url->delete();
        $this->dispatchBrowserEvent('banner-style', [
            'style' => 'success',
            'message' => 'Stream url deleted'
        ]);

        $this->reset();
    }

    public function resetFilters()
    {
        $this->reset();
    }

    private function slugify($str) {
        $slug = str_replace(' ', '-', $str);

        return strtolower($slug);
    }


    private function createDirectory($directories = []) {

      $dir = implode('/', $directories);

      if (!file_exists($dir)) {
        Storage::makeDirectory('public/' . $dir);
      } else {
        return false;
      }
    }

    public function render()
    {
        return view('livewire.episode-index', [
            'episodes' => Episode::where('season_id', $this->season->id)
                ->search('episode_number', $this->search)
                ->orderBy('episode_number', $this->sort)
                ->paginate($this->perPage)
        ]);
    }
}
