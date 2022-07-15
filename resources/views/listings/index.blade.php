<x-layout>
    {{-- @if (!Auth::check())
    @include('partials._hero')
  @endif --}}

    {{-- @include('partials._banner') --}}
    @include('partials._search')


    <div class=" gap-4 space-y-4 mx-4 my-4">
        @if (request('search'))
            <h3>
                Search results for <b>'{{ request('search') }}'</b>
            </h3>
        @endif
    </div>
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @unless(count($listings) == 0)

            @foreach ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @endforeach
        @else
            <p>No listings found</p>
        @endunless

    </div>

    <div class="mt-6 p-4">
        {{ $listings->links() }}
    </div>
</x-layout>
