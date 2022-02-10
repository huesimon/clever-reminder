<span x-data="{ open: false }">
    <!-- Trigger -->
    <span x-on:click="open = true">
        {{$trigger}}
    </span>

    <!-- Modal -->
    <div
        x-show="open"
        style="display: none"
        x-on:keydown.escape.prevent.stop="open = false"
        role="dialog"
        aria-modal="true"
        x-id="['modal-title']"
        :aria-labelledby="$id('modal-title')"
        class="fixed inset-0 overflow-y-auto"
    >
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

        <!-- Panel -->
        <div
            x-show="open" x-transition
            x-on:click="open = false"
            class="relative min-h-screen flex items-center justify-center p-4"
        >
            <div
                x-on:click.stop
                x-trap.noscroll.inert="open"
                class="relative max-w-2xl w-full bg-white border border-black p-8 overflow-y-auto"
            >
                {{$dialog}}
            </div>
        </div>
    </div>
</span>
