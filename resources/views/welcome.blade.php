<x-front-layout>

    <main class="max-w-6xl mx-auto mt-6 min-h-screen">
        <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
            <div class="m-2 p-2 text-2xl font-bold text-indigo-600 dark:text-indigo-300">
                <h1>Episodes</h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 rounded">
                @foreach ($episodes as $episode)
                    <x-movie-card>
                        <a href="{{ route('episode.player', ['episode' => $episode->id]) }}">
                            {{ $episode->season->series->name }}
                            <div class="dark:text-white font-bold group-hover:text-blue-400">
                                Season {{ $episode->season->season_number }} 
                                Episode {{ $episode->episode_number }}
                            </div>
                        </a>
                    </x-movie-card>
                @endforeach
            </div>
        </section>
        <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
            <div class="m-2 p-2 text-2xl font-bold text-indigo-600 dark:text-indigo-300">
                <h1>Series</h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 rounded">
                @foreach ($series as $serie)
                    <x-movie-card>
                        <a href="{{ route('series.show', [$serie->id]) }}">
                            <div class="dark:text-white font-bold group-hover:text-blue-400">
                                {{ $serie->name }}
                            </div>
                        </a>
                    </x-movie-card>
                @endforeach
            </div>
        </section>
    </main>
</x-front-layout>