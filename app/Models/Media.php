<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends \Spatie\MediaLibrary\Models\Media
{
    use HasFactory;

    public function voters()
    {
        return $this->morphToMany(User::class, 'votable')->withPivot(['type']);
    }
}
