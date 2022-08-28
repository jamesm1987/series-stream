<x-front-layout>


        <form action={{ route('instagram.store') }} method="POST" class="min-h-full shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Username
                </label>
                <input name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
            </div>
            <div class="mb-4">
                <input class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Save">
            </div>
        </form>

        @if (!empty($profiles))
            @foreach ($profiles as $profile)
                {{ $profile->username }}
                @if (!$profile->hasInstagramAccess())
                    <a class="" href="{{ $profile->getInstagramAuthUrl() }}">Click to give instagram permission</a>
                @endif
                <form action="{{ route('instagram.delete', ['profile' => $profile->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button>DELETE</button>
                </form>
            @endforeach
        @endif
</x-front-layout>