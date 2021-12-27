<x-front-layout>
    <div class="max-w-6xl mx-auto mt-4">
        <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                <h1>{{ $data['show']}}</h1>
                <h3>Season {{ $data['season'] }} Episode {{ $data['episode'] }}</h3>

                <video controls width="100%">

                    <source src="{{ $data['url']}}"
                            type="video/mp4">

                    Sorry, your browser doesn't support embedded videos.
                </video>
            </div>
        </section>
    </div>
</x-front-layout>