<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'title', 
        'slug', 
        'thumbnail',
        'body',
        'active',
        'published_at',
        'user_id',];
    protected $casts = [
        'published-at' => 'datetime'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }


    public function getFormattedDate()
{
    // Verifica se published_at é uma string e converte se necessário
    if (is_string($this->published_at)) {
        $date = new DateTime($this->published_at);
    } elseif ($this->published_at instanceof DateTime) {
        $date = $this->published_at;
    } else {
        return 'Data inválida'; // Ou algum tratamento apropriado
    }
    
    return $date->format('F jS Y');
}

    public function shortBody(): string
    {
        return Str::words(strip_tags($this->body), 30);
    }

    public function getThumbnail()
    {
        if(str_starts_with($this->thumbnail, 'http'))
        {
            return $this->thumbnail;
        }
        return '/storage/'.$this->thumbnail;
    }
}
