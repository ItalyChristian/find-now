@props(['header' => null, 'data' => null, 'actions'])
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="w-full">
        <div class="w-full bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            @foreach ($header as $item)
                                <th {{ $attributes->merge(['class' => 'px-4 py-3 py-3 px-4 font-semibold text-sm']) }}>
                                    {{ $item['value'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr {{ $attributes->merge(['class' => 'border-b dark:border-gray-700']) }}>
                                @foreach ($header as $h)
                                    <td {{ $attributes->merge(['class' => 'px-4 py-3']) }}>
                                        {{ $item['id'] }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        {{-- {{ $header }} --}}
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</section>
