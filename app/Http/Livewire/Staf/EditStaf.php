<?php


namespace App\Http\Livewire\Staf;

use App\Models\Staf;
use Livewire\Component;

class EditStaf extends Component
{
    // model name
    public $nama;
    // model noHp
    public $noHp;
    // model transportasi
    public $transportasi;
    // model qty_task
    public $jumlah_tugas;


    // set  stafId
    public $stafId;
    // rule validation
    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'noHp' => "required|numeric|digits:12|unique:stafs,no_hp,$this->stafId",
            'transportasi' => 'required|string|max:255',
            'jumlah_tugas' => 'required|numeric',
        ];
    }


    // mount
    public function mount($stafId)
    {
        $this->stafId = $stafId;
        $staf = Staf::find($this->stafId);
        if ($staf) {
            $this->nama = $staf->nama;
            $this->noHp = $staf->no_hp;
            $this->transportasi = $staf->transportasi;
            $this->jumlah_tugas = $staf->qty_task;
        }

    }

    // updated
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // method edit
    public function edit()
    {
        $this->validate();

        $staf = Staf::find($this->stafId);
        if ($staf) {
            $staf->update([
                'name' => $this->nama,
                'no_hp' => $this->noHp,
                'transportasi' => $this->transportasi,
                'qty_task' => $this->jumlah_tugas,
            ]);

            session()->flash('message', "Staf $staf->nama updated successfully!");
            return to_route('staf');
        }
    }

    // render
    public function render()
    {
        return view('livewire.staf.edit-staf');
    }
}

