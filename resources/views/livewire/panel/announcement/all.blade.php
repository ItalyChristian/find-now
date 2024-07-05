<div>
    @if (count($announcements) > 0)
        <h1 class="mb-12 text-4xl font-bold text-gray-800 dark:text-gray-200">Meus anúncios</h1>
        <livewire:panel.announcement.create />
        <br>
        <br>
        <br>
        <br>
        {{ $announcements }}
    @else
        <x-empty-announcement />
    @endif
</div>
