<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FeaturedTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'slug',
        'tag_id'
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
