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
        <x-_location-item-charge-item type="Type 2"
            :available="$location?->availability?->available_iec_type_2_regular +
                $location?->availability?->available_iec_type_2_fast"
            :total="$location?->availability?->total_iec_type_2_regular +
                $location?->availability?->total_iec_type_2_fast" />
        <x-_location-item-charge-item type="CHADEMO"
        :available="$location?->availability?->available_chademo_fast +
            $location?->availability?->available_chademo_ultra"
        :total="$location?->availability?->total_chademo_fast +
            $location?->availability?->total_chademo_ultra" />
        <x-_location-item-charge-item type="CCS"
        :available="$location?->availability?->available_ccs_fast +
            $location?->availability?->available_ccs_ultra"
        :total="$location?->availability?->total_ccs_fast +
            $location?->availability?->total_ccs_ultra" />
    </div>
</li>
