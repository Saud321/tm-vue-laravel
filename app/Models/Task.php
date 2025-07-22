<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Task extends Model
{
    use SoftDeletes;
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'status',
        'category'
    ];

    protected $dates = ['deadline'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
