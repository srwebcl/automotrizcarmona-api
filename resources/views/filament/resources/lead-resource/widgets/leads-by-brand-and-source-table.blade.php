<x-filament-widgets::widget>
    <x-filament::section heading="Leads por Marca y Origen" class="p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left divide-y table-auto fi-ta-table divide-gray-200 dark:divide-white/5">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">Marca</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400 text-center">Total Leads</th>
                        @foreach($sources as $source)
                            <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400 text-center capitalize">{{ str_replace('_', ' ', $source) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @forelse($data as $row)
                        <tr class="fi-ta-row transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ $row['brand'] }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-primary-600 text-center">{{ number_format($row['total']) }}</td>
                            @foreach($sources as $source)
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300 text-center">
                                    @if($row[$source] > 0)
                                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20">
                                            {{ number_format($row[$source]) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($sources) + 2 }}" class="px-4 py-8 text-sm text-center text-gray-500">No hay datos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
