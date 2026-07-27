<x-filament-panels::page>
    <div class="mb-4">
        {{ $this->form }}
    </div>

    @if ($reportWidgets = $this->getReportWidgets())
        <x-filament-widgets::widgets
            :columns="$this->getHeaderWidgetsColumns()"
            :data="['filters' => $this->filters]"
            :widgets="$reportWidgets"
            class="fi-page-header-widgets"
        />
    @endif
</x-filament-panels::page>
