<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => ['required', 'string', 'max:255'],
            'artist'    => ['required', 'string', 'max:255'],
            'tag1'      => ['required', 'string', 'max:50'],
            'tag2'      => ['nullable', 'string', 'max:50'],
            'reference' => ['nullable', 'string', 'max:255'],
            'link'      => ['nullable', 'url', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'     => 'nama lagu',
            'artist'    => 'penyanyi',
            'tag1'      => 'tag utama',
            'tag2'      => 'tag kedua',
            'reference' => 'referensi',
            'link'      => 'link',
        ];
    }
}