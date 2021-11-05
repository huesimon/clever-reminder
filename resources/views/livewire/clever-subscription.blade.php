<div>
    <input wire:model="search" type="text" placeholder="Search charge points..." />
    <select wire:model='plugType' name="type" id="type">
        <option value="">Select type</option>
        @foreach($connectorTypes as $type)
        <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
    {{$locations->count()}}
    <ul>
        @foreach($locations as $location)
        <li class="hover:bg-gray-300">
            <div class="group flex items-center justify-between">
                <div class="flex flex-row space-x-2">
                    <p>Id: {{ $location->id }}</</p>
                    <p>{{ $location->name }}</p>
                </div>
                @if(Auth::user() && $plugType)
                <div class="opacity-0 group-hover:opacity-100">


                        @if (Auth::user()->subscriptions->where('location_id', $location->id)->where('type', $plugType)->first())
                        <button wire:click='delete({{$location}})'
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                        </button>
                        @else
                        <button wire:click='save({{$location}})'
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Save
                        </button>
                        @endif
                </div>
                @endif
            </div>
        </li>
        @endforeach
    </ul>
</div>