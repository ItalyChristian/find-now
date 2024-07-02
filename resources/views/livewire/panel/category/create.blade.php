<div>
    <x-button icon="plus" position="left" wire:click="$toggle('modal')">Cadastrar</x-button>

    <x-modal title="Cadastrar Categoria" size="5xl" blur wire>
        <form wire:submit="store">

            <x-input label="Name *" hint="Insert your name" class="mb-4" wire:model="name" />

            <x-button type="submit" class="mt-6">Cadastrar</x-button>
        </form>
    </x-modal>
</div>
