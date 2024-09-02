<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageDestination extends Model
{
    use HasFactory;
    protected $table = 'image_destinations';
    protected $fillable = [
        'destination_id',
        'path',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

}
