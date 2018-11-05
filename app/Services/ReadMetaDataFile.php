<?php namespace App\Services;

use App\Album;
use App\Artist;
use Storage;

class ReadMetaDataFile
{
  private $title      = 'unknow';
  private $artist     = 'unknow';
  private $album      = 'unknow';
  private $genre      = 'unknow';
  private $year       = 'unknow';
  private $duration = 0;
  
  public function getFileMetaData(string $file)
  {
      $getId3    = new \getID3();
      $audioInfo = $getId3->analyze($file);

      if(isset($audioInfo['playtime_seconds'])){
        $this->duration = $audioInfo['playtime_seconds'];
      }

      if(isset($audioInfo['tags']['quicktime'])){
        $meta           = $audioInfo['tags']['quicktime'];
        $this->title    = isset($meta['title'][0])  ? $meta['title'][0] : $this->title;
        // $this->artist   = isset($meta['artist'][0]) ? $meta['artist'][0] : $this->artist;
        // $this->album    = isset($meta['album'][0])  ? $meta['album'][0] : $this->album;
        // $this->genre    = isset($meta['genre'][0])  ? $meta['genre'][0] : $this->genre;
        // $this->year     = isset($meta['year'][0])   ? $meta['year'][0] : $this->year;
        $this->year     = isset($meta['creation_date'][0]) ? $meta['creation_date'][0] : null;
      }

      if(isset($audioInfo['tags']['id3v1'])){
        $meta           = $audioInfo['tags']['id3v1'];
        $this->title    = isset($meta['title'][0])  ? $meta['title'][0] : $this->title;
        // $this->artist   = isset($meta['artist'][0]) ? $meta['artist'][0] : $this->artist;
        // $this->album    = isset($meta['album'][0])  ? $meta['album'][0] : $this->album;
        // $this->genre    = isset($meta['genre'][0])  ? $meta['genre'][0] : $this->genre;
        // $this->year     = isset($meta['year'][0])   ? $meta['year'][0] : $this->year;
      }

      if(isset($audioInfo['tags']['id3v2'])){
        $meta     = $audioInfo['tags']['id3v2'];
        $this->title    = isset($meta['title'][0])  ? $meta['title'][0] : $this->title;
        // $this->artist   = isset($meta['artist'][0]) ? $meta['artist'][0] : $this->artist;
        // $this->album    = isset($meta['album'][0])  ? $meta['album'][0] : $this->album;
        // $this->genre    = isset($meta['genre'][0])  ? $meta['genre'][0] : $this->genre;
        // $this->year     = isset($meta['year'][0])   ? $meta['year'][0] : $this->year;
      }

      $data = new \stdClass();
      $data->title    = utf8_encode($this->title);
      // $data->artist   = utf8_encode($this->artist);
      // $data->album    = utf8_encode($this->album);
      // $data->genre    = utf8_encode($this->genre);
      // $data->year     = utf8_encode($this->year);
      $data->duration = utf8_encode($this->duration);

      // $artist = Artist::select('id')->where('name', $data->artist)->first();
      // $data->artist_id = $artist != null ? $artist->id : null;
      
      // $album = Album::select('id')->where('name', $data->album)->first();
      // $data->album_id = $album != null ? $album->id : null;

      // if($data->artist_id == null){
      //     $artist = new Artist();
      //     $artist->name = $data->artist;
      //     $artist->image = "/images/default_artist.png";
      //     $artist->save();
      //     $data->artist_id = $artist->id;
      // }
      // if($data->album_id == null){
      //     $album = new Album();
      //     $album->name      = $data->album;
      //     $album->genre     = $data->genre;
      //     $album->artist_id = $data->artist_id;
      //     $album->year      = $data->year;
      //     $album->save();
      //     $data->album_id = $album->id;

      //     if (isset($audioInfo['comments']['picture']['0']['data'])) {
      //       $image = $audioInfo['comments']['picture']['0']['data'];
      //       Storage::disk('local')->put("albums_cover/$album->id", $image);
      //       $album->cover = "/albums_cover/$album->id";
      //     } else {
      //       $album->cover = "/images/default_icon.png";
      //     }

          
      //     $album->save();

      // };

      return $data;
    }
}