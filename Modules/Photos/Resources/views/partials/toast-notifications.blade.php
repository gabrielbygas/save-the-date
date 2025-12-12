{{-- modify by claude --}}
{{-- Toast notifications module Photos - Composant reutilisable --}}
{{-- Inclut: Container pour toasts, support success/error/warning/info, animations --}}

@props(['position' => 'top-right'])

@php
    $positionClasses = match($position) {
        'top-left' => 'top-20 left-4',
        'top-center' => 'top-20 left-1/2 -translate-x-1/2',
        'top-right' => 'top-20 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'bottom-center' => 'bottom-4 left-1/2 -translate-x-1/2',
        'bottom-right' => 'bottom-4 right-4',
        default => 'top-20 right-4',
    };
@endphp

{{-- Container pour les notifications toast --}}
<div id="toast-container" class="fixed {{ $positionClasses }} z-[100] flex flex-col gap-3 max-w-sm w-full pointer-events-none">
    {{-- Toast Success --}}
    @if (session('success'))
        <div class="toast-notification pointer-events-auto bg-white rounded-xl shadow-lg shadow-green-500/10 border border-green-100 p-4" data-toast-type="success">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">Succes</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="window.PhotosToast.dismissToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Toast Error --}}
    @if (session('error'))
        <div class="toast-notification pointer-events-auto bg-white rounded-xl shadow-lg shadow-red-500/10 border border-red-100 p-4" data-toast-type="error">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">Erreur</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="window.PhotosToast.dismissToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Toast Warning --}}
    @if (session('warning'))
        <div class="toast-notification pointer-events-auto bg-white rounded-xl shadow-lg shadow-yellow-500/10 border border-yellow-100 p-4" data-toast-type="warning">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">Attention</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ session('warning') }}</p>
                </div>
                <button type="button" onclick="window.PhotosToast.dismissToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Toast Info --}}
    @if (session('info'))
        <div class="toast-notification pointer-events-auto bg-white rounded-xl shadow-lg shadow-blue-500/10 border border-blue-100 p-4" data-toast-type="info">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">Information</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ session('info') }}</p>
                </div>
                <button type="button" onclick="window.PhotosToast.dismissToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
