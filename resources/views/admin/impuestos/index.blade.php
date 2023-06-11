<x-app-layout>
    @section('title', 'Categorías')
    <!-- Mensaje redirect -->
    <x-mensaje/>

    <div class="bg-gray-200 border-gray-200 shadow rounded-md sm:mx-5 lg:mx-20 mt-16 mb-5 pb-1">
        <!-- Añadir categoría -->
        <div class="flex items-center justify-center xl:justify-start bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Impuestos</h1>
            <a href="{{ route('admin.impuestos.create') }}"
               class="text-3xl text-emerald-500 hover:text-emerald-600 transition duration-150 ease-in-out">
                <i class="fa-regular fa-square-plus"></i>
            </a>
        </div>

        <!-- Resultados -->
        @if(count($impuestos) < 1)
            <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white">
                <span>No se han encontrado resultados.</span>
            </div>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1 sm:mx-5 my-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                    <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span>Descripción</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                                <span>Porcentaje</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($impuestos as $impuesto)
                        <tr
                            class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $impuesto->descripcion }}
                            </th>

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $impuesto->porcentaje }}
                            </th>

                            <td class="px-6 py-4 text-right flex items-center">
                                <div>
                                    <a href="{{ route('admin.impuestos.edit', $impuesto) }}"
                                       class="text-xl text-blue-400">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                                <span class="px-1 text-gray-400 select-none">|</span>
                                <div>
                                    <form action="{{ route('admin.impuestos.destroy', $impuesto) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('¿Quieres eliminar el impuesto seleccionado?')"
                                                class="text-xl text-red-400" type="submit">
                                            <i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-slate-300 dark:bg-gray-800">
                        <td colspan="4" class="px-6 py-4">
                            {{ $impuestos->links('vendor.pagination.tailwind') }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-app-layout>
