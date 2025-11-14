<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $append = ['full_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        'emp_type','emp_id','first_name','middle_name','last_name','email', 'password','mobile','roles_id','image','image_path','is_active','is_ip_base','permissions','ip','update_from_ip','created_at','updated_at','updated_by','created_by', 'allow_multi_login',
        'max_approved_limit',
        'individual_cap',
        'overall_cap',
        'group_cap',
        'is_created_directly',
        'claim_examiner_max_approved_limit',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        if(!empty($this->first_name) && !empty($this->last_name)) {
            $full_name = $this->first_name . " " . $this->last_name;
        } else {
            $full_name = '';
        }
        return $full_name;
    }
    
    public function getFullName() {
        return $this->hasOne(User::class, 'id');
    }

    public function usersRole() {
        return $this->belongsTo(RoleUser::class, 'id', 'user_id');
    }

    public function roles()
    {
        return $this->hasOne(Role::class,'roles_id');
    }

    public function userIps()
    {
        return $this->hasMany(UserIp::class);
    }
    public function role() {
        return $this->hasOneThrough(Role::class,RoleUser::class,'user_id','id',null,'role_id');
    }
    public function rolesData()
    {
        return $this->belongsTo(Role::class,'roles_id');
    }
    public function beneficiary() 
    {
        return $this->hasOne(Beneficiary::class, 'user_id');
    }
     public function contractor() 
    {
        return $this->hasOne(Principle::class, 'user_id');
    }
    public function rmUsers()
    {
        return $this->hasMany(RmUser::class, 'rm_user_id');
    }
}
