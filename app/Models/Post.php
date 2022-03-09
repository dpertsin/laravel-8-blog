<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['category', 'author'];

    public function scopeFilter($query, array $filters) // Post::newQuery()->filter()
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
            ->where('title', 'like', '%' . $search . '%') // This uses SQL commands
            ->orWhere('body', 'like', '%' . $search . '%'); // This uses SQL commands
        });
        
        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas(
                'category',
                fn ($query) =>
                    $query->where('slug', $category)
            ); // This uses SQL commands
        });
                
        $query->when($filters['author'] ?? false, function ($query, $author) {
            $query->whereHas(
                'author',
                fn ($query) =>
                    $query->where('username', $author)
            ); // This uses SQL commands
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
