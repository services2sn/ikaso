<?php

namespace App\Repositories;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserRepository extends Authenticatable
{
    use Notifiable;

    /**
     * The repository's table name.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'activated_account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    /**
     * Check wether the use has an activated account or not
     *
     * @return Boolean
     */
    public function hasActivatedAccount() {
        return $this->activated_account == true;
    }

    /**
     * Activate the user account
     *
     * @return void
     */
    public function activateAccount() {
        $this->activated_account = true;
        $this->save();
    }
}
