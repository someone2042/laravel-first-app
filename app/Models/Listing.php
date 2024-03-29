<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title','user_id','logo','company', 'location','website','email','description','tags'];

    public function scopeFilter($query, array $filters){
        if($filters['tag'] ??false){
            $query->where('tags','like','%'.request('tag').'%');
        }
        if($filters['search'] ??false){
            $query->Where('description','like','%'.request('search').'%')
            ->orWhere('title','like','%'.request('search').'%')
            ->orWhere('tags','like','%'.request('search').'%')
            ->orderByRaw(
                "CASE 
                    WHEN title LIKE '%" . request('search') . "%' THEN 1 
                    WHEN tags LIKE '%" . request('search') . "%' THEN 2 
                    WHEN description LIKE '%" . request('search') . "%' THEN 3 
                END"
            );
        }
    }
    //Relationships
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
