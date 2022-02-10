<li class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
    <div class="w-full flex items-center justify-between p-6 space-x-6">
        <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
                <h3 class="text-gray-900 text-sm font-medium truncate">{{ $location->name }} </h3>
                <span
                    class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">#{{
                    $location->clever_id }}</span>
            </div>
            <x-modal>
                <x-slot:trigger><p class="mt-1 text-gray-500 text-sm truncate"> <a href="#" class="">{{ $location->description }} </a></p> </x-slot:trigger>
                    <x-slot:dialog>
                        <h1> Description </h1>
                        <p class="break-words"> {{ $location->description }} </p>
                    </x-slot:dialog>
            </x-modal>
        </div>
        {{-- icon --}}
        {{-- <x-icon.heart></x-icon.heart> --}}
    </div>
    <div>
        <x-_location-item-charge-item type="Type 2" available="4" total="8" />
        <x-_location-item-charge-item type="CHADEMO" available="4" total="8" />
        <x-_location-item-charge-item type="CCS" available="4" total="8" />
    </div>
</li>
{{-- Auth::user()->subscriptions->where('location_id', $location->id)->where('type', $plugType)->first() --}}
