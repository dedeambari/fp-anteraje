<?php

namespace App\Http\Livewire\Staf;

use App\Models\Staf;
use App\Models\User;
use Livewire\Component;

class AddStaf extends Component
{
    // model name
    public $nama, $noHp, $transportasi, $jumlah_tugas;

    public $password_default;

    public function mount(){
        $this->password_default = config('app.password_default');
    }

    // rule validation
    protected $rules = [
        'nama' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
        'noHp' => 'required|numeric|digits:12|unique:stafs,no_hp',
        'transportasi' => 'required|string|max:255',
        'jumlah_tugas' => 'required|numeric',
    ];

    // method update realtime validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // create User
    public function store()
    {
        // validasi
        $this->validate();

        // Create username with name
        $nama = strtolower(trim($this->nama));
        $username = substr_count($nama, ' ') > 0 ? explode(' ', $nama)[0] : $nama;

        // Create staf
        Staf::create([
            'nama' => $this->nama,
            'username' => $username . '_' . mt_rand(100, 999),
            'no_hp' => $this->noHp,
            'transportasi' => $this->transportasi,
            'qty_task' => $this->jumlah_tugas,
            'password' => bcrypt($this->password_default),
        ]);

        // Reset Input
        $this->reset();
        return to_route('staf')->with('message', "Staf $this->nama created successfully!");
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.staf.add-staf');
    }
}
