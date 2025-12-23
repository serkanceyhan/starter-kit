<div 
    x-data="{ showScrollTop: false }"
    @scroll.window="showScrollTop = (window.pageYOffset > 500) ? true : false"
    class="fixed bottom-6 right-6 z-40"
>
    <button 
        x-show="showScrollTop"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="p-3 bg-primary hover:bg-blue-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
        aria-label="Yukarı Çık"
    >
        <span class="material-symbols-outlined text-xl">arrow_upward</span>
    </button>
</div>
