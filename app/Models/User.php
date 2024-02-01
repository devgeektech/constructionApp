<?php

/**
 * Created by Reliese Model.
 */

 namespace App\Models;

 // use Illuminate\Contracts\Auth\MustVerifyEmail;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Foundation\Auth\User as Authenticatable;
 use Illuminate\Notifications\Notifiable;
 use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
 
 class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;
	
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'role_id',
		'image',
		'phone',
		'address',
		'remember_token',
		'is_social',
		'social_id',
		'login_type'
	];

	public function providers() {
        return $this->hasMany(Provider::class,'user_id','id');
    }

	public function role()
    {
        return $this->belongsTo(Role::class);
    }

	public function store()
    {
        return $this->belongsTo(Store::class);
    }
	public function product()
    {
        return $this->belongsTo(Product::class);
    }
	// protected function role_id(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) =>  [1, 2, 3][$value],
    //     );
    // }
}
