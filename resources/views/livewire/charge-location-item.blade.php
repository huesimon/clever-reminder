<div class="flex flex-col">
    <div class="h-32 md:h-32 bg-indigo-400 flex flex-col p-4 font-bold text-white">
        <p class="">{{ $location->name }} @if($location->is_future) <strong>FUTURE</strong> @endif
        </p>
        <p class=""># {{$location->id}}</p>
        @if(Auth::user() && $plugType)
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
        @endif
    </div>
    <div class="flex flex-col p-4">
        {{-- {{$location->availability->available_ccs_ultra}} --}}
        @if($location->connectors->firstWhere('type', 'iec_type_2'))
        <div class="grid grid-cols-6">
            <p class="">Icon</p>
            <p class="col-span-4">
                {{$location?->availability?->available_iec_type_2_regular +
                $location?->availability?->available_iec_type_2_fast}}
                /
                {{$location?->availability?->total_iec_type_2_regular +
                $location?->availability?->total_iec_type_2_fast}}
                available</p>
            <p class="col-start-2 col-span-4">IEC TYPE 2 regular</p>
        </div>
        @endif
        @if($location->connectors->firstWhere('type', 'chademo'))
        <div class="grid grid-cols-6">
            <p class="">Icon</p>
            <p class="col-span-4">
                {{$location?->availability?->available_chademo_fast +
                $location?->availability?->available_chademo_ultra}}
                /
                {{$location?->availability?->total_chademo_fast +
                $location?->availability?->total_chademo_ultra}}
                available</p>
            <p class="col-start-2 col-span-4">CHADEMO fast</p>
        </div>
        @endif
        @if($location->connectors->firstWhere('type', 'ccs'))
        <div class="grid grid-cols-6">
            <p class="">Icon</p>
            <p class="col-span-4">
                {{$location?->availability?->available_ccs_fast +
                $location?->availability?->available_ccs_ultra}}
                /
                {{$location?->availability?->total_ccs_fast +
                $location?->availability?->total_ccs_ultra}}
                available</p>
            <p class="col-start-2 col-span-4">CHADEMO fast</p>
        </div>
        @endif
        {{-- <div class="grid grid-cols-6">
            <p class="">Icon</p>
            <p class="col-span-4">1/1 available</p>
            <p class="col-start-2 col-span-4">CCS DC 50kW (fast)</p>
        </div>
        <div class="grid grid-cols-6">
            <p class="">Icon</p>
            <p class="col-span-4">1/1 available</p>
            <p class="col-start-2 col-span-4">CCS DC 50kW (fast)</p>
        </div> --}}
    </div>
    <div class="flex flex-row space-x-2 p-4">
        <div class="h-12 w-12 bg-indigo-800">maps icon</div>
        <div>{{$location->line1 . " " . $location->line2}}</div>
    </div>
    <div class="flex flex-col p-4 space-y-4">
        <div class="w-full h-40 bg-gray-800">
            {{-- <img src="{{$location->image_url}}" alt="Location image"> --}}
        </div>
        <div class="font-bold"> {{ $location->opening_hours_dk }} </div>
        <div>{{ $location->description }}</div>
    </div>
</div>