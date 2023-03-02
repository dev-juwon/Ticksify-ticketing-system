<?php

namespace App\Http\Livewire\User;

use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class ProfileManager extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }

    public function mount()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function save()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password) {
            $this->user->update([
                'password' => \Hash::make($this->password),
            ]);
        }

        $this->reset('password', 'password_confirmation');

        $this->emitSelf('saved');
    }

    public function getUserProperty()
    {
        return \Auth::user();
    }

    public function render()
    {
        return view('livewire.user.profile-manager')->layout('layouts.guest');
    }
}
