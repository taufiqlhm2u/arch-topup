<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;

class Home extends Component
{
    public $games = [];
    public $search = '';

    public function populerGame()
    {
        $this->games = Game::limit(6)->get();
    }

    public function mount()
    {
        $this->populerGame();
    }

    public function searchGame($query)
    {
        $this->games = Game::whereRaw(
            'LOWER(name) LIKE ?',
            ['%' . strtolower($query) . '%']
        )->get();
    }

    public function updatedSearch()
    {
        if (trim($this->search) === '') {
            $this->populerGame();
        } else {
            $this->searchGame($this->search);
        }
    }


    public function render()
    {
        return view('livewire.home');
    }
}
