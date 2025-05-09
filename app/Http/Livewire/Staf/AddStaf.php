<?php

namespace App\Http\Livewire\Staf;

use App\Models\Staf;
use App\Models\User;
use Livewire\Component;

class AddStaf extends Component
{
    // model name
    public $nama;
    // model noHp
    public $noHp;
    // model transportasi
    public $transportasi;
    // model qty_task
    public $jumlah_tugas;

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
        $this->validate();

        // buat username berdasarkan name
        $nama = strtolower(trim($this->nama));
        $username = substr_count($nama, ' ') > 0 ? explode(' ', $nama)[0] : $nama;

        // Buat user baru
        Staf::create([
            'nama' => $this->nama,
            'username' => $username ."_". mt_rand(100, 999),
            'no_hp' => $this->noHp,
            'transportasi' => $this->transportasi,
            'qty_task' => $this->jumlah_tugas,
            'password' => bcrypt("AnterAje500"),
        ]);

        session()->flash('message', "Staf successfully added: {$this->nama}");
        // Bersihkan input form setelah berhasil disubmit
        $this->reset();
        return to_route('staf');
    }

    // render
    public function render()
    {
        return view('livewire.staf.add-staf');
    }
}
