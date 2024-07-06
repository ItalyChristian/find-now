<div>
    @if (count($rows) > 0)
        <h1 class="mb-12 text-4xl font-bold text-gray-800 dark:text-gray-200">Meus anúncios</h1>
        <livewire:panel.announcement.create />

        <div class="my-12">
            <x-table :$headers :$rows id="users">
                @interact('column_status', $row)
                    <x-boolean :boolean="$row['status']" color-when-true="green" lg />
                @endinteract
                @interact('column_action', $row)
                    <div class=" flex gap-4 ">
                        <livewire:panel.announcement.delete :key="$row['id'] . '-delete-' . time()" :announcement_id="$row['id']" />
                        <livewire:panel.announcement.update :key="$row['id'] . '-update-' . time()" :announcement_id="$row['id']" />
                    </div>
                @endinteract
            </x-table>
        </div>
    @else
        <x-empty-announcement />
    @endif
</div>
