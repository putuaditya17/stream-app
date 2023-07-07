<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index() {
        $movies = Movie::all();
        return view('admin.movies', ['movies' => $movies]);
    }

    public function create() {
        return view('admin.movie-create');
    }
    
    public function edit($id) {
        $movie = Movie::find($id);

        return view('admin.movie-edit', ['movie' => $movie]);
    }

    public function store(Request $request) {
        $data = $request->except('_token');

        $request->validate([
            'title' => 'required|string',
            'small_thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'large_thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'cast' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required'
        ]);

        $smallThumbnail = $request->small_thumbnail;
        $largeThumbnail = $request->large_thumbnail;

        $orignalSmallThumbnailName = Str::random(10).$smallThumbnail->getClientOriginalName();
        $orignalLargeThumbnailName = Str::random(10).$largeThumbnail->getClientOriginalName();

        $smallThumbnail->storeAs('public/thumbnail', $orignalSmallThumbnailName);
        $largeThumbnail->storeAs('public/thumbnail', $orignalLargeThumbnailName);

        $data['small_thumbnail'] = $orignalSmallThumbnailName;
        $data['large_thumbnail'] = $orignalLargeThumbnailName;

        Movie::create($data);

        return redirect()->route('admin.movie')->with('success', "Movie created");
    }

    public function update(Request $request, $id) {
        $data = $request->except('_token');

        $request->validate([
            'title' => 'required|string',
            'small_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'large_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'cast' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required'
        ]);

        $movie = Movie::find($id);

        if($request->small_thumbnail){
            // save new image
            $smallThumbnail = $request->small_thumbnail;
            $orignalSmallThumbnailName = Str::random(10).$smallThumbnail->getClientOriginalName();
            $smallThumbnail->storeAs('public/thumbnail', $orignalSmallThumbnailName);
            $data['small_thumbnail'] = $orignalSmallThumbnailName;

            // delete old image
            Storage::delete('public/thumbnail/'.$movie->small_thumbnail);
        }

        if($request->large_thumbnail){
            // save new image
            $largeThumbnail = $request->large_thumbnail;
            $orignalLargeThumbnailName = Str::random(10).$largeThumbnail->getClientOriginalName();
            $largeThumbnail->storeAs('public/thumbnail', $orignalLargeThumbnailName);
            $data['large_thumbnail'] = $orignalLargeThumbnailName;

            // delete old image
            Storage::delete('public/thumbnail/'.$movie->large_thumbnail);
        }

        $movie->update($data);
        return redirect()->route('admin.movie')->with('success', "Movie updated");
    }

    public function destroy($id){
        Movie::find($id)->delete();

        return redirect()->route('admin.movie')->with('success', "Movie deleted");
    }
}
