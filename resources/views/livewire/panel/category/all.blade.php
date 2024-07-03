<div>
    <div class="mt-6">
        <x-table :$headers :$rows filter paginate id="users">

            @interact('column_action', $row)
                <div class=" flex gap-4 ">
                    <livewire:panel.category.delete :key="$row->pluck('id')->join('-')" :category="$row" />

                    <x-button.circle color="blue" icon="pencil-square" wire:click="update('{{ $row->id }}')" />
                </div>
            @endinteract
        </x-table>
    </div>
</div>
