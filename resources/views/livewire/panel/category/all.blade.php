<div>
    <div class="mt-6">
        <x-table :$headers :$rows filter paginate id="users">

            @interact('column_action', $row)
                <div class=" flex gap-4 ">
                    <livewire:panel.category.delete :key="$row->pluck('id')->join('-') . '-' . time()" :category="$row" />
                    <livewire:panel.category.update :key="$row->pluck('id')->join('-') . '-' . time()" :category="$row" />
                </div>
            @endinteract
        </x-table>
    </div>
</div>
