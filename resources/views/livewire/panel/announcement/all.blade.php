<div>
    @if (count($announcements) > 0)
        <h1 class="mb-12 text-4xl font-bold text-gray-800 dark:text-gray-200">Meus anúncios</h1>
        <livewire:panel.announcement.create />
        @foreach ($announcements as $announcement)
            <div>
                {{ $announcement['title'] }}
                -
                <livewire:panel.announcement.delete :announcement_id="$announcement['id']" :key="$announcement['id'] . '-' . time()" />
            </div>
        @endforeach
    @else
        <x-empty-announcement />
    @endif
</div>
