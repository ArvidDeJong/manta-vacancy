<flux:main container>
    <x-manta.breadcrumb :$breadcrumb />
    <div class="flex mt-4">
        <div class="flex-grow">
            @if ($vacancy)
                <x-manta.buttons.large type="add" :href="route('vacancy.reaction.create', ['vacancy' => $vacancy->id])" />
            @endif
            @if (isset($config['settings']) && count($config['settings']) > 0)
                <x-manta.buttons.large type="gear" :href="route('vacancy.reaction.settings')" />
            @endif
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
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                wire:click="dosort('created_at')">
                Aangemaakt</flux:table.column>

            @if ($this->fields['firstname']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'firstname'" :direction="$sortDirection"
                    wire:click="dosort('firstname')">
                    Voornaam</flux:table.column>
            @endif
            @if ($this->fields['lastname']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'lastname'" :direction="$sortDirection"
                    wire:click="dosort('lastname')">
                    Achternaam</flux:table.column>
            @endif
            @if ($this->fields['email']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection"
                    wire:click="dosort('email')">
                    Email</flux:table.column>
            @endif

        </flux:table.columns>
        <flux:table.rows>
            @foreach ($items as $item)
                <flux:table.row data-id="{{ $item->id }}">
                    @if ($this->fields['uploads']['active'])
                        <flux:table.cell><x-manta.tables.image :item="$item->image" /></flux:table.cell>
                    @endif
                    <flux:table.cell>{{ $item->created_at }}</flux:table.cell>
                    @if ($this->fields['firstname']['active'])
                        <flux:table.cell>{{ $item->firstname }}</flux:table.cell>
                    @endif
                    @if ($this->fields['lastname']['active'])
                        <flux:table.cell>{{ $item->lastname }}</flux:table.cell>
                    @endif
                    @if ($this->fields['email']['active'])
                        <flux:table.cell>{{ $item->email }}</flux:table.cell>
                    @endif
                    <flux:table.cell>{{ $item->vacancy ? substr($item->vacancy->title, 0, 50) : null }}
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
