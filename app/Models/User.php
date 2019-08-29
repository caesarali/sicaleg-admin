<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'username', 'email', 'password', 'role_id', 'last_login_ip', 'last_login_at'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['deleted_at'];

    public function volunteer() {
        return $this->hasOne(Volunteer::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function assignRole($role) {
        if (is_string($role)) {
            $role = Role::whereName($role)->first();
            return $this->update(['role_id' => $role->id ?? null]);
        }
    }

    public function hasRole($roles) {
        if (is_string($roles)) {
            $roles = [$roles];
        }
        foreach ($roles as $role) {
            if ($this->role->name === $role) return true;
        }
        return false;
    }
}
