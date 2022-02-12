<div class="absolute inset-0 py-6 px-4 sm:px-6 lg:px-8">
    <div class="h-full border-2 border-gray-200 border-dashed rounded-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-4 max-w-xs">
                    <label for="location_search" class="block text-sm font-medium text-gray-700">Search for location</label>
                    <div class="mt-1">
                        <input wire:model.debounce.500ms="search" type="text" name="location_search" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search for location">
                    </div>
                </div>
                <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($locations as $location)
                            <x-location-item :location="$location"></x-location-item>
                    @endforeach
                </ul>

            <div class="mt-8 p-4">{{ $locations->links() }}</div>
            </div>
    </div>

</div>
