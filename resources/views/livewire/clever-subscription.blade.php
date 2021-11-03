<div>
    <input wire:model="search" type="text" placeholder="Search charge points..." />
    <ul>
        @foreach($locations as $location)
        <li>
            <div class="group flex justify-between space-y-4">
                <div>{{ $location->name }}</div>
                <div class="opacity-0 group-hover:opacity-100">
                    <button wire:click='save({{$location}})' class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Save
                    </button>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>