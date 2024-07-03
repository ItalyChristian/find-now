<div>
    <div class="mt-6">
        <x-table :$headers :$rows filter paginate id="users">

            @interact('column_action', $row)
                <x-button.circle color="red" icon="trash" wire:click="delete('{{ $row->id }}')" />
                <x-button.circle color="blue" icon="pencil-square" wire:click="update('{{ $row->id }}')" />
            @endinteract
        </x-table>
    </div>
</div>
