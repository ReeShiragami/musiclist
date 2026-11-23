<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Song extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'songs';

    protected $fillable = [
        'title',
        'artist',
        'tag1',
        'tag2',
        'reference',
        'link',
    ];

    public function tags(): array
    {
        return array_values(array_filter([$this->tag1, $this->tag2]));
    }
}