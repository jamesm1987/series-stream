<?php

namespace App\Http\Livewire;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SeasonIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    public $seasonNumber;
    public $showSeasonModal = false;
    public $seasonId;
    public $seriesId;

    protected $rules = [
        'seasonNumber' => 'required|numeric'
    ];
    
    public function mount(Series $series)
    {
        $this->seriesId = $series;
    }

    public function createSeason()
    {
        $season = Season::create([
            'series_id' => $this->seriesId,
            'season_number' => $this->season_number
        ]);

        $this->reset('seasonNumber');
        
        if ($season) {
            $this->dispatchBrowserEvent('banner-style', [
                'style' => 'success',
                'message' => 'Season created'
            ]);
        } else {
            $this->dispatchBrowserEvent('banner-style', [
                'style' => 'danger',
                'message' => 'Season already exists'
            ]);
        }
    }

    public function showEditModal($id)
    {
        $this->seasonId = $id;
        $this->loadSeason();
        $this->showSeasonModal = true;
    }

    public function loadSeason()
    {
        $season = Season::findOrFail($this->seasonId);
        $this->seasonNumber = $season->season_number;
    }

    public function closeSeasonModal()
    {
        $this->showSeasonModal = false;
    }

    public function updateSeason()
    {
        $this->validate();

        $season = Season::findOrFail($this->seasonId);
        $season->update([
            'season_number' => $this->seasonNumber
        ]);

        $this->dispatchBrowserEvent('banner-style', [
            'style' => 'success',
            'message' => 'Season updated'
        ]);

        $this->reset(['seasonNumber', 'seasonId', 'showSeasonModal']);
    }

    public function deleteSeason($id)
    {
        $season = Season::findOrFail($id);

        $season->delete();

        $this->reset(['seasonNumber', 'seasonId', 'showSeasonModal']);
        $this->dispatchBrowserEvent('banner-style', [
            'style' => 'success',
            'message' => 'Season deleted'
        ]);
    }

    public function resetFilters()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.season-index', [
            'seasons' => Season::where('series_id', $this->seriesId)
                ->search('season_number', $this->search)
                ->orderBy('season_number', $this->sort)
                ->paginate($this->perPage)
        ]);
    }
}
