@extends('layout')

@section('content')
        @include('partials._banner')


    <div class="lg:grid sm:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @forelse ($listings as $listing)
            <x-listing-card :listing="$listing" />
        @empty
            <p>No listings available</p>
        @endforelse
        {{-- <p>{{ $listings }}</p> --}}
    </div>
@endsection
