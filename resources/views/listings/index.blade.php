<x-layout>
    @auth
    @else
        @include('partials._hero')
    @endauth
    @include('partials._search')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

        @unless (count($listings) == 0)
            @foreach ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @endforeach
        @else
            <p>no listings found</p>
        @endunless
        <div class="mt-6 p-4 col-span-full">
            {{ $listings->links() }}
        </div>
    </div>
</x-layout>
