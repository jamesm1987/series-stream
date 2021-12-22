<x-front-layout>
    @if (!empty($series))
        <main class="my-2">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h3 class="flex text-white font-bold text-4xl">{{ $series->name }}</h1>

                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1 class="flex text-white font-bold text-xl">Seasons</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            @foreach ($series->seasons as $season)
                                <x-movie-card>
                                    <a href="{{ route('season.show', [$series->id, $season->id]) }}">
                                        <span class="text-white">{{ $season->season_number }}</span>
                                    </a>
                                </x-movie-card>
                            @endforeach
                        </div>
                    </div>
                    <div class="w-4/12">
                        <h1 class="flex text-white font-bold text-xl">Latest seasons</h1>
                        <div class="grid grid-cols-3 gap-2">
                            @if (!empty($latests))
                                @foreach ($latests as $lserie)
                                    <a href="{{ route('series.show', $lserie->id) }}">
                                        {{ Test }}
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