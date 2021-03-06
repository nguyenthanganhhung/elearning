<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'released_at',
        'status'
    ];

    public function getUpdatedAtAttribute()
    {
        return (new Carbon($this->attributes['updated_at']))->format('d/m/Y h:m:s');
    }
    public function getReleasedAtAttribute()
    {
        return (new Carbon($this->attributes['released_at']))->format('d/m/Y');
    }
    public function setReleasedAtAttribute($value)
    {
        $this->attributes['released_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = Auth::check() ? Auth::user()->id : $value;
    }
    public function categories()
    {
        return $this->morphToMany('App\Models\Category', 'categorizable')->where('root','course');
    }
    public function image()
    {
        return $this->morphOne('App\Models\ImageMeta','image_meta');
    }
    public function programs()
    {
        return $this->belongsToMany('App\Models\Program');
    }
    public function author()
    {
        return $this->belongsTo('App\Models\User');
    }
}
