<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Atajos de Administración
        </x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
            <a href="/admin/brands/create" class="group flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 hover:ring-2 hover:ring-primary-500 hover:bg-white dark:hover:bg-gray-800 transition-all">
                <x-filament::icon icon="heroicon-o-tag" class="w-10 h-10 text-cyan-500 mb-3 group-hover:scale-110 transition-transform" />
                <span class="font-semibold text-gray-900 dark:text-gray-100 text-center">Crear Marca de Livianos</span>
            </a>
            
            <a href="/admin/truck-brands/create" class="group flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 hover:ring-2 hover:ring-blue-500 hover:bg-white dark:hover:bg-gray-800 transition-all">
                <x-filament::icon icon="heroicon-o-tag" class="w-10 h-10 text-blue-500 mb-3 group-hover:scale-110 transition-transform" />
                <span class="font-semibold text-gray-900 dark:text-gray-100 text-center">Crear Marca de Camiones</span>
            </a>
            
            <a href="/admin/vehicle-models/create" class="group flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 hover:ring-2 hover:ring-emerald-500 hover:bg-white dark:hover:bg-gray-800 transition-all">
                <x-filament::icon icon="heroicon-o-truck" class="w-10 h-10 text-emerald-500 mb-3 group-hover:scale-110 transition-transform" />
                <span class="font-semibold text-gray-900 dark:text-gray-100 text-center">Agregar Modelo Livianos</span>
            </a>
            
            <a href="/admin/trucks/create" class="group flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 hover:ring-2 hover:ring-green-500 hover:bg-white dark:hover:bg-gray-800 transition-all">
                <x-filament::icon icon="heroicon-o-truck" class="w-10 h-10 text-green-500 mb-3 group-hover:scale-110 transition-transform" />
                <span class="font-semibold text-gray-900 dark:text-gray-100 text-center">Agregar Modelo Camiones</span>
            </a>

            <a href="/admin/vehicle-versions" class="group flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 hover:ring-2 hover:ring-amber-500 hover:bg-white dark:hover:bg-gray-800 transition-all">
                <x-filament::icon icon="heroicon-o-currency-dollar" class="w-10 h-10 text-amber-500 mb-3 group-hover:scale-110 transition-transform" />
                <span class="font-semibold text-gray-900 dark:text-gray-100 text-center">Actualizar Precios</span>
            </a>

            <a href="/admin/banners/create" class="group flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 hover:ring-2 hover:ring-rose-500 hover:bg-white dark:hover:bg-gray-800 transition-all">
                <x-filament::icon icon="heroicon-o-presentation-chart-bar" class="w-10 h-10 text-rose-500 mb-3 group-hover:scale-110 transition-transform" />
                <span class="font-semibold text-gray-900 dark:text-gray-100 text-center">Añadir un Banner</span>
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
