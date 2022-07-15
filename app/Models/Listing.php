<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Storage;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = [''];
    // protected $fillable = ['title', 'description', 'company', 'location', 'email', 'website','tags','logo','user_id];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'LIKE', '%' . request('tag') . '%');
        }
        if ($filters['search'] ?? false) {
            $query->where('title', 'LIKE', '%' . request('search') . '%')
                ->orWhere('description', 'LIKE', '%' . request('search') . '%')
                ->orWhere('tags', 'LIKE', '%' . request('search') . '%')
                ->orWhere('location', 'LIKE', '%' . request('search') . '%');
        }
    }
    // public function getLogoAttributes($value)
    // {
    // $rs = asset('storage/images/listing/' . $value);
    // dd($rs);
    // return $rs;
    // return $value ? asset('storage/images/listing/' . $value) : asset('/images/no-image.png');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
