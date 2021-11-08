<div>
    <input wire:model="search" type="text" placeholder="Search charge points..." />
        <select wire:model='plugType' name="type" id="type">
        <option value="">Select type</option>
        @foreach($connectorTypes as $type)
        <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
    {{$locations->count()}}
    <div class="grid grid-cols-3 gap-4 bg-gray-300">
        @foreach($locations as $location)
            <livewire:charge-location-item :location="$location" :plugType="$plugType" wire:key="{{ $loop->index }}">
        @endforeach
    </div>
</div>