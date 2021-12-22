<?php

namespace App\Http\Livewire;

use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use App\Models\StreamUrl;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class EpisodeIndex extends Component
{


    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    public $episode;
    public $url;
    public $episodeNumber;
    public $episodeId;
    public $showEpisodeModal = false;

    protected $rules = [
        'episodeNumber' => 'required|numeric'
    ];

    public function mount(Series $series, Season $season) {
        $this->seriesId = $series->id;
        $this->seasonId = $season->id;

    }

    public function createEpisode()
    {
        $episode = Episode::create([
            'season_id' => $this->seasonId,
            'episode_number' => $this->episodeNumber
        ]);

        $episode->stream()->create([
            'url' => $this->url
        ]);

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

    public function render()
    {
        return view('livewire.episode-index', [
            'episodes' => Episode::where('season_id', $this->seasonId)
                ->search('episode_number', $this->search)
                ->orderBy('episode_number', $this->sort)
                ->paginate($this->perPage)
        ]);
    }
}
