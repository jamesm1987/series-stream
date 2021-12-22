<x-front-layout>
    <div class="max-w-6xl mx-auto mt-4">
        <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                @foreach ($series as $serie)
                    <x-movie-card>
                        <x-slot name="image">
                            <a href="{{ route('series.show', $serie->id) }}">
                                
                                <div class="absolute inset-0 z-10 bg-gradient-to-t from-black to-transparent"></div>

                                <div
                                    class="absolute x-10 left-2 top-2 h-6 w-12 bg-gray-800 group-hover:bg-gray-700 text-blue-400 text-center rounded">
                                    New
                                </div>
                                <div
                                    class="absolute z-10 bottom-2 left-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">
                                    {{ $serie->seasons_count }} Season/s
                                </div>
                            </a>
                        </x-slot>
                        <a href="{{ route('series.show', $serie->id) }}">
                            <div class="dark:text-white font-bold group-hover:text-blue-400">
                                {{ $serie->name }}
                            </div>
                        </a>
                    </x-movie-card>
                @endforeach
            </div>
            <div class="m-2 p-2">
                {{ $series->links() }}
            </div>
        </section>
    </div>
</x-front-layout>