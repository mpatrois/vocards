<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        "title",
        "genre",
        "duration",
        "year",
        "url",
        "user_id",
        "artist_id",
        "album_id",
    ];

    public function playlists()
    {
        return $this->belongsToMany('App\Playlist');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function album()
    {
        return $this->belongsTo('App\Album');
    }

    public function artist()
    {
        return $this->belongsTo('App\Artist');
    }

    public static function search($words){
        $query = Song::selectRaw('distinct songs.*')
        ->with('album.artist','artist')
        ->leftJoin('albums', 'songs.album_id', '=', 'albums.id')
        ->leftJoin('artists', 'songs.artist_id', '=', 'artists.id');
        
        $query->where(function($q) use($words){
            foreach ($words as $word) {
                $q->where('albums.name','like', "%$word%");
            }
        })
        ->orWhere(function($q) use($words){
            foreach ($words as $word) {
                $q->where('songs.title','like', "%$word%");
            }
        })
        ->orWhere(function($q) use($words){
            foreach ($words as $word) {
                $q->where('artists.name','like', "%$word%");
            }
        });
        
        return $query->get();
    }
}
