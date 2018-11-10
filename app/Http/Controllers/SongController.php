<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\ReadMetaDataFile;

use App\Song;
use App\Sort;
use App\Playlist;
use App\Album;
use Storage;
use Auth;

class SongController extends Controller
{
    public function index(Request $request){
        $songs = Song::orderBy('created_at', 'desc')->get();
        return $songs;
    }

    public function play($id)
    {
        $song = Song::find($id);
        return Storage::disk('local')->download($song->url);
    }

    public function store(Request $request, ReadMetaDataFile $reader){
        $songs = [];

        foreach ($request->songs as $songFile) {
            $tmpSongFilePath = 'uploaded_files/'.$songFile->getClientOriginalName();
            $songFile->storeAs('uploaded_files/', $songFile->getClientOriginalName());
            $file = storage_path('app/'.$tmpSongFilePath);

            $metaData = $reader->getFileMetaData($file);
            $nameFile = $this->generateFileNameFromPath($file);
            $binaryData = file_get_contents($file);

            $song = new Song([
                'title'          => $metaData->title,
                'duration'       => $metaData->duration,
                'url'            => $nameFile,
            ]);
            $song->save();
            Storage::disk('local')->put($nameFile, $binaryData);
            Storage::delete($tmpSongFilePath);
            $songs[] = $song;
        }
        return $songs;
    }

    public function update($id, Request $request){
        $song = Song::find($id);
        $song->fill($request->all());
        if($song->description === null){
            $song->description = '';
        }
        $song->valid = true;
        $song->save();
        return $song;
    }
    
    public function destroy($id){
        $song = Song::find($id);
        $song->delete();
    }

    private function generateFileNameFromPath($path)
    {
        $originalName = pathinfo($path, PATHINFO_FILENAME);
        $originalExt  = pathinfo($path, PATHINFO_EXTENSION);
        $slug = str_slug($this->gen_uuid().date('now').$originalName);
        $finalName = $slug.'.'.$originalExt;
        return $finalName;
    }

    private function getSongGroupBySortId($song, $sortId){
        foreach ($song->groups as $group) {
            if($group->sort_id == $sortId){
                return $group;
            }
        }
        return null;
    }

    public function exportData(){
        $sorts = Sort::with('groups')->get();
        $songs = Song::with('groups')->get();
        $finalData = [];
        $finalData['header'] = [];
        $finalData['header'][] = 'Label des groupes';
        foreach ($sorts as $sort) {
            $allGroupNames = $sort->groups->map(function($group){
                return $group->name;
            });
            $finalData['header'][] = implode(' - ',$allGroupNames->toArray());
        }
        foreach ($songs as $song) {
            $finalData[$song->id] = [];
            $finalData[$song->id][] = $song->title;
            foreach ($sorts as $sort) {
                $labelInSort = '';
                $groupOfSort = $this->getSongGroupBySortId($song, $sort->id);
                if($groupOfSort !== null){
                    $labelInSort = $groupOfSort->name;
                }
                $finalData[$song->id][] = $labelInSort;
            }
        }

        $callback = function() use ($finalData) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($finalData as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        ,   'Content-type'        => 'text/csv'
        ,   'Content-Disposition' => 'attachment; filename=data.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
        ]);
    }

    private function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

}
