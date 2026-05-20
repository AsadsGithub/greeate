<div x-data="{ toasts: [] }" @toast.window="toasts.push({ message: $event.detail.message, type: $event.detail.type || 'success' }); setTimeout(() => toasts.shift(), 4000)" class="fixed bottom-4 right-4 z-50 space-y-2">
    <template x-for="(toast, index) in toasts" :key="index">
        <div x-show="true" x-transition class="px-4 py-3 rounded-lg shadow-lg text-white text-sm"
             :class="toast.type === 'error' ? 'bg-red-500' : 'bg-green-500'" x-text="toast.message"></div>
    </template>
</div>
