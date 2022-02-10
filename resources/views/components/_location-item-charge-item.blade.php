@props(['type', 'available', 'total'])
<div class="mt-4 flex divide-x divide-gray-200">
    <div class="flex-1 flex justify-between">
        <h4 class="-mr-px w-0 flex-1 inline-flex items-center justify-center py-4 hover:text-gray-500 text-gray-900 text-sm font-medium truncate">
            {{$type}}
        </h4>
    </div>
    <div class="-mr-px w-0 flex-1 inline-flex items-center justify-center py-4  hover:text-gray-500 text-gray-900 text-sm font-medium truncate">
        {{$available}} / {{$total}}
    </div>
</div>
