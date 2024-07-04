<div>
    <x-button.circle color="blue" icon="pencil" wire:click="$toggle('modal')" />

    <x-modal title="Editar Categoria" size="5xl" blur wire>
        <form wire:submit="update">

            <x-input label="Name *" hint="Insert your name" class="mb-4" wire:model="name" />

            <x-button type="submit" class="mt-6">Editar</x-button>
        </form>
    </x-modal>
</div>
