<?php

namespace App\Http\Livewire;

use App\Models\AkunAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public $user;

    public function rules()
    {
        $rules = [
            'user.nama' => 'required|max:15|min:5|regex:/^[a-zA-Z ]+$/u',
            'user.username' => 'required|max:20|min:5',
        ];

        // Kalau user mengisi salah satu field password, validasi semuanya
        if ($this->user['old_password'] || $this->user['new_password'] || $this->user['new_password_confirmation']) {
            $rules['user.old_password'] = 'required|min:5';
            $rules['user.new_password'] = 'required|min:5|same:user.new_password_confirmation';
            $rules['user.new_password_confirmation'] = 'required|min:5';
        }

        return $rules;
    }


    public function mount()
    {
        $akun = AkunAdmin::find(auth()->user()->id);
        $this->user = $akun ?? new AkunAdmin();
        $this->user->nama = auth()->user()->nama;
        $this->user->username = auth()->user()->username;
    }


    public function save()
    {
        $this->validate();

        $akun = AkunAdmin::find(auth()->user()->id);

        $akun->nama = $this->user['nama'];
        $akun->username = $this->user['username'];

        if (
            !empty($this->user['old_password']) &&
            !empty($this->user['new_password']) &&
            !empty($this->user['new_password_confirmation'])
        ) {
            if (!\Hash::check($this->user['old_password'], $akun->password)) {
                $this->addError('user.old_password', 'Password lama salah.');
                return;
            }

            // Simpan password baru
            $akun->password = bcrypt($this->user['new_password']);
        }

        $akun->save();

        session()->flash('message', 'Profil berhasil diperbarui.');
    }


    public function render()
    {
        return view('livewire.profile');
    }
}
