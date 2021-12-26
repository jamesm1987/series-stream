<x-front-layout>
    @if (!empty($season))
        <main class="my-2">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
    
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">Season {{ $season->season_number }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>Series: <strong>{{ $series->name }}</strong></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1 class="flex text-white font-bold text-xl">Episodes</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            @foreach ($season->episodes as $episode)
                                <x-movie-card>
                                    <a href="{{ route('episodes.show', $episode->id) }}">
                                        <span class="text-white">{{ $episode->episode_number }}</span>
                                    </a>
                                </x-movie-card>
                            @endforeach
                        </div>
                    </div>
                    <div class="w-4/12">
                        <h1 class="flex text-white font-bold text-xl">Latest seasons</h1>
                        <div class="grid grid-cols-3 gap-2">
                            @if (!empty($latests))
                                @foreach ($latests as $lseason)
                                    <a href="{{ route('seasons.show', [$lseason->series->id, $lseason->id]) }}">
                                        Season {{ $lseason->season_number }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </section>

        </main>
    @endif

</x-front-layout>