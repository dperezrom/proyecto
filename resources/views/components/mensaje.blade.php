<div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)"
     class="fixed left-1/2 -translate-x-1/2 z-40 w-full sm:w-auto">
    @if (session()->has('success'))
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-5 py-3 shadow-md">
            <i class="fa-solid fa-circle-check"></i>
            {{ session()->get('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-5 py-3 shadow-md">
            <i class="fa-solid fa-circle-xmark"></i>
            {{ session()->get('error') }}
        </div>
    @endif
</div>
