<?php

namespace App\Http\Livewire\Auth;

use App\Models\AkunAdmin;
use App\Models\User;
use Livewire\Component;

class Login extends Component
{

    // model email
    public $username = '';

    // model password
    public $password = '';
    // remember me
    public $remember_me = false;

    // rules validation
    protected $rules = [
        'username' => 'required|string|regex:/^[a-z0-9_]+$/|min:6',
        'password' => 'required|min:6',
    ];

    // mount
    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended('/dashboard');
        }
    }

    // method login
    public function login()
    {
        $this->validate();
        if (auth()->attempt(['username' => $this->username, 'password' => $this->password], $this->remember_me)) {
            $user = AkunAdmin::where(['username' => $this->username])->first();
            auth()->login($user, $this->remember_me);
            return redirect()->intended('/dashboard');
        } else {
            return $this->addError('username', trans('auth.failed'));
        }
    }

    // render
    public function render()
    {
        return view('livewire.auth.login');
    }
}
