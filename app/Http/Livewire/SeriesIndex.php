<?php

namespace App\Http\Livewire;

use App\Models\Series;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SeriesIndex extends Component
{

    use WithPagination;

    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    public $name;
    public $showSeriesModal = false;
    public $seriesId;

    protected $rules = [
        'name' => 'required|unique:series'
    ];


    public function createSeries()
    {
        $series = Series::create([
            'name' => $this->name
        ]);

        $this->reset();
        if ($series) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'success', 
                'message' => 'Series created'
            ]);
        } else {
            $this->dispatchBrowserEvent('banner-style', [
                'style' => 'danger',
                'message' => 'Series already exists'
            ]);
        }
    }

    public function showEditModal($id)
    {
        $this->seriesId = $id;
        $this->loadSeries();
        $this->showSeriesModal = true;
    }

    public function loadSeries()
    {
        $series = Series::findOrFail($this->seriesId);
        $this->name = $series->name;
    }

    public function closeSeriesModal()
    {
        $this->showSeriesModal = false;
    }

    public function updateSeries()
    {
        $this->validate();
        $series = Series::findOrFail($this->seriesId);

        $series->update([
            'name' => $this->name
        ]);

        $this->dispatchBrowserEvent('banner-style', [
            'style' => 'success',
            'message' => 'Series updated'
        ]);

        $this->reset();
    }

    public function deleteSeries($id)
    {
        $series = Series::findOrFail($id);
        $series->delete();
        $this->reset();
        $this->dispatchBrowserEvent('banner-style', [
            'style' => 'success',
            'message' => 'Series deleted'
        ]);
    }

    public function resetFilters()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.series-index', [
            'series' => Series::search('name', $this->search)->orderBy('name', $this->sort)->paginate($this->perPage)
        ]);
    }
}
