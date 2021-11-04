<div>
    <input wire:model="search" type="text" placeholder="Search charge points..." />
    <ul>
        @foreach($locations as $location)
        <li class="hover:bg-gray-300">
            <div class="group flex items-center justify-between">
                <div class="flex flex-row space-x-2">
                    <p>Id: {{ $location->id }}</</p>
                    <p>{{ $location->name }}</p>
                </div>
                <div class="">

                    <select wire:model='plugType' name="type" id="type">
                        <option value="">Select type</option>
                        @foreach($location->getConnectorTypes() as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>

                </div>
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