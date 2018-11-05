<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\ReadMetaDataFile;

use App\Song;
use App\Sort;
use App\Group;
use Storage;
use Auth;

class SortController extends Controller
{
    public function index(Request $request){
        return Sort::with('groups.songs')->get();
    }

    public function store(Request $request){
    //    dd($request->all());
       $sort = new Sort($request->all());
       $sort->save();

       foreach ($request->groups as $groupInfo) {
           $group = new Group();
           $group->name = $groupInfo['name'];
           $group->sort_id = $sort->id;
           $group->save();
           foreach ($groupInfo['songs'] as $songId) {
                $group->songs()->attach($songId);
           }
       }

        
    //    $project->closed 
    }

    public function destroy($id){
        // $song = Song::find($id);
        // // $song->playlists()->detach();
        // $song->delete();
    }

}
