<div>
    <x-button.circle color="blue" icon="pencil" wire:click="$toggle('modal')" />
    <x-modal title="Editar Anuncio" size="5xl" blur wire persistent>

        <form wire:submit="update">

            <div class="mb-4">
                <x-select.styled label="Categoria *" :options="$categories" select="label:name|value:id"
                    wire:model="category_id" />
            </div>
            <div class="mb-4">
                <x-input label="Name *" wire:model='title' />
            </div>
            <div class="mb-4">
                <x-textarea label="Description *" wire:model='description' />
            </div>
            <div class="mb-4">
                <x-select.styled label="Forma de Cobrança *" :options="[
                    ['name' => 'Por Hora', 'id' => 'hours'],
                    ['name' => 'Por Dia', 'id' => 'day'],
                    ['name' => 'Por Semana', 'id' => 'week'],
                    ['name' => 'Por Mês', 'id' => 'month'],
                    ['name' => 'Por Visita', 'id' => 'visit'],
                    ['name' => 'Por Serviço', 'id' => 'service'],
                    ['name' => 'Após a conclusão', 'id' => 'conclusion'],
                    ['name' => 'A Combinar', 'id' => 'combine'],
                ]" select="label:name|value:id"
                    wire:model="method_receipt" />
            </div>
            <div class="mb-4">
                <x-input label="Preço *" wire:model="price" />
            </div>
            <div class="mb-4">
                <x-upload label="Images" hint="Adicione até 6 fotos" multiple wire:model='files' />
            </div>
            <div class="mb-4">
                <x-toggle wire:model="status">
                    <x-slot:label>
                        Status
                    </x-slot:label>
                </x-toggle>
            </div>
            <x-button type="submit"
                class="mt-6 bg-orange-500 hover:bg-orange-600 text-white font-bold">Anunciar</x-button>
        </form>
    </x-modal>
</div>
