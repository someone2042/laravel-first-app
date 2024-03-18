<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    public function scopeFilter($query, array $filters){
        if($filters['tag'] ??false){
            $query->where('tags','like','%'.request('tag').'%');
        }
        if($filters['search'] ??false){
            $query->Where('description','like','%'.request('search').'%')
            ->orWhere('title','like','%'.request('search').'%')
            ->orWhere('tags','like','%'.request('search').'%');
        }
    }
}
