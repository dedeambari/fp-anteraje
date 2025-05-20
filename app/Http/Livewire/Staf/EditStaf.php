<?php

namespace App\Http\Livewire\Staf;

use App\Models\Staf;
use Livewire\Component;

class EditStaf extends Component
{
    // staf id Paramters visivle
    public $stafId;
    // input Model Livewire
    public $nama, $noHp, $transportasi, $jumlah_tugas;

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
        // staf id
        $this->stafId = $stafId;
        // find staf
        $staf = Staf::withTrashed()->find($this->stafId);
        if ($staf) {
            $this->nama = $staf->nama;
            $this->noHp = $staf->no_hp;
            $this->transportasi = $staf->transportasi;
            $this->jumlah_tugas = $staf->qty_task;
        }
    }

    // updated Validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // method edit
    public function edit()
    {
        // validasi
        $this->validate();

        // update staf
        $staf = Staf::withTrashed()->find($this->stafId);

        if ($staf) {
            if ($staf->trashed()) {
                return to_route('staf')->with('error', "Staf di non-aktifkan!, aktifkan staf terlebih dahulu!");
            }
            $staf->update([
                'name' => $this->nama,
                'no_hp' => $this->noHp,
                'transportasi' => $this->transportasi,
                'qty_task' => $this->jumlah_tugas,
            ]);

            return to_route('staf')->with('message', "Staf $this->nama updated successfully!");
        }
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.staf.edit-staf');
    }
}
