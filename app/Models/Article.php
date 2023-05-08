<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'meta_description',
        'description',
        'user_id',
        'image',
        'feature',
    ];

    protected $appends = [
        'updated_at_original',
    ];

    // created_at attribute mutator 
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y h:i:s')
        );
    }

    // updated_at attribute mutator 
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y h:i:s')
        );
    }

    // get the original timestamp format of updated_at attribute
    protected function getUpdatedAtOriginalAttribute(): string
    {
        return Carbon::parse($this->updated_at)->format('Y-d-m h:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
