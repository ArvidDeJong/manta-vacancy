<flux:main container>
    <x-manta.breadcrumb :$breadcrumb />
    <div class="flex mt-4">
        <div class="flex-grow">
            <x-manta.buttons.large type="add" :href="route($this->route_name . '.create')" />

        </div>
        <div class="w-1/5">
            <x-manta.input.search />
        </div>
    </div>
    <x-manta.tables.tabs :$tablistShow :$trashed />
    <flux:table :paginate="$items">
        <flux:table.columns>
            @if ($this->fields['uploads']['active'])
                <flux:table.column></flux:table.column>
            @endif
            <flux:table.column sortable :sorted="$sortBy === 'title'" :direction="$sortDirection"
                wire:click="dosort('title')">
                Titel</flux:table.column>
            {{-- @if ($this->fields['slug']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection"
                    wire:click="dosort('slug')">Slug
                </flux:table.column>
            @endif --}}
            <flux:table.column>Reacties</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($items as $item)
                <flux:table.row data-id="{{ $item->id }}">
                    @if ($this->fields['uploads']['active'])
                        <flux:table.cell><x-manta.tables.image :item="$item->image" /></flux:table.cell>
                    @endif
                    <flux:table.cell>{{ $item->title }}</flux:table.cell>
                    @if ($this->fields['slug']['active'])
                        <flux:table.cell>
                            @if ($item->slug && Route::has('website.vacancy-item'))
                                <a href="{{ route('website.vacancy-item', ['slug' => $item->slug]) }}"
                                    class="text-blue-500 hover:text-blue-800">
                                    {{ $item->slug }}
                                </a>
                            @endif
                        </flux:table.cell>
                    @endif
                    <flux:table.cell>
                        <a href="{{ route('vacancy.reaction.list', ['vacancy_id' => $item]) }}"
                            class="text-blue-500 hover:text-blue-800">{{ count($item->reactions) > 0 ? count($item->reactions) : 0 }}</a>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" href="{{ route($this->route_name . '.read', $item) }}"
                            icon="eye" />
                        <x-manta.tables.delete-modal :item="$item" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:main>
