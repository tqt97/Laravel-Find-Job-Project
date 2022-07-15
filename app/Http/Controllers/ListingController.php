<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingCreateRequest;
use App\Http\Requests\ListingEditRequest;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request('tag'));
        $listings = Listing::latest()->filter(request(['tag', 'search']))->paginate(10);
        return view('listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListingCreateRequest $request)
    {
        $listing = Listing::create($request->validated() + ['user_id' => auth()->id()]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo')->getClientOriginalName();
            // $logo = $request->file('logo')->store('logos', 'public');
            $request->file('logo')->storeAs('images/listing', $image, 'public');
            $listing->update(['logo' => $image]);
        }

        return redirect()->route('listings.show', $listing)->with('message', 'Listing created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        return view('listings.show', compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            // abort(403, 'Unauthenticated user');
            return redirect()->route('listings.index')->with('message', 'You are not authorized to edit this listing!');
        } else {
            $listing = Listing::findOrFail($listing->id);
            return view('listings.edit', compact('listing'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ListingEditRequest $request, Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            return redirect()->route('listings.index')->with('message', 'You are not authorized to edit this listing!');
        } else {
            $data = $request->validated();

            if ($request->hasFile('logo') && request('logo') != '') {

                $old_url_image = public_path('storage/images/listing/' . $listing->logo);
                if (File::exists($old_url_image) && $listing->logo != '') {
                    unlink($old_url_image);
                }

                $image = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('images/listing', $image, 'public');

                $data['logo'] = $image;
            }
            $listing->update($data);

            return redirect()->route('listings.show', $listing)->with('message', 'Listing updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            return redirect()->route('listings.index')->with('message', 'You are not authorized to edit this listing!');
        } else {
            $listing->delete();
            return redirect()->route('listings.index')->with('message', 'Listing deleted successfully!');
        }
    }

    public function manage()
    {
        $listings = auth()->user()->listings;
        return view('listings.manage', compact('listings'));
    }
}
