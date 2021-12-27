<x-front-layout>
    <div class="max-w-6xl mx-auto mt-4">
        <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded my-2">
                <div>
                    <h1 class="text-xl">{{ $data['show']}}</h1>
                    <h2 class="text-lg">Season {{ $data['season'] }} Episode {{ $data['episode'] }}</h2>
                </div>
            </div>
            <div>
                
                <video
                    id="my-video"
                    class="video-js vjs-big-play-centered"
                    controls
                    preload="auto"
                    width="640"
                    data-setup="{}">
                    <source src="{{ url($data['url']) }}" type="video/mp4">
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, 
                        and consider upgrading to a web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">
                            supports HTML5 video
                        </a>
                    </p>
                </video>
            </div>
        </section>
    </div>
</x-front-layout>