<x-app-layout>
    @section('title', 'Usuarios')
    <!-- Mensaje de éxito -->
    <div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)">
        @if (session()->has('success'))
            <div class="p-3 text-green-700 bg-green-300 rounded mb-4 px-5">
                {{ session()->get('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-3 text-red-700 bg-red-300 rounded mb-4 px-5">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>

    <div class=" bg-gray-200 border-gray-200 shadow rounded-md pb-5 sm:mx-5 lg:mx-20">
        <!-- Añadir usuario -->
        <div class="flex items-center bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Usuarios</h1>
            <a href="{{ route('admin.users.create') }}"
                class="text-3xl text-emerald-500 hover:text-emerald-600 transition duration-150 ease-in-out">
                <i class="fa-regular fa-square-plus"></i>
            </a>
        </div>

        <!-- Buscador -->
        <div x-data="{ open: localStorage.getItem('menu_filtro') }">
            <div x-on:click="open = (open == 'true') ? 'false':'true'; localStorage.setItem('menu_filtro', open);"
                class="bg-gray-800 text-emerald-400 px-5 py-2 cursor-pointer">
                <button><i class="fa-solid fa-filter pr-2"></i>Filtros</button>
            </div>

            <div x-show="open == 'true'" x-cloak x-transition
                class="px-5 py-3 text-white bg-gray-700 rounded-b-lg border-b-8 border-gray-900">
                <form action="{{ route('admin.users') }}" method="GET">
                    <!-- Orden -->
                    <input type="hidden" name="orden" value="{{ old('orden') }}">

                    <div class="flex flex-wrap flex-row">
                        <!-- Nombre -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="name" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Nombre:
                            </label>

                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full flex-auto"
                                value="{{ request()->query('name') }}">
                        </div>

                        <!-- Email -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="email" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Email:
                            </label>

                            <input type="text" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full flex-auto"
                                value="{{ request()->query('email') }}">
                        </div>

                        <!-- Email -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="telefono" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Teléfono:
                            </label>

                            <input type="text" name="telefono" id="telefono"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full flex-auto"
                                value="{{ request()->query('telefono') }}">
                        </div>

                        <!-- Rol -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="rol" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Rol:
                            </label>

                            <select name="rol" id="rol"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full">
                                <option value='' {{ request()->query('rol') == '' ? 'selected' : '' }}>-</option>
                                <option value='usuario' {{ request()->query('rol') == 'usuario' ? 'selected' : '' }}>
                                    Usuario</option>
                                <option value='admin' {{ request()->query('rol') == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                            </select>

                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between mt-5">
                        <button type="submit"
                            class="text-white bg-emerald-500 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 font-medium rounded-md px-2 py-1 text-center"><i
                                class="fa-solid fa-magnifying-glass pr-2"></i>Buscar</button>

                        <button
                            class="bg-gray-400 hover:bg-gray-500 text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-md px-2 py-1">
                            <a href="{{ route('admin.users') }}"><i class="fa-solid fa-xmark pr-2"></i>Limpiar</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Resultados -->
        @if (count($users) < 1)
            <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white">
                <span>No se han encontrado resultados.</span>
            </div>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1 sm:mx-5 my-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                    <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                        @php
                            // Filtrado campos
                            $link = '';
                            foreach ($campos as $campo) {
                                $link .= '&' . $campo . '=' . urlencode(request()->get($campo));
                            }

                            // Orden
                            $orden = request()->get('orden');
                            $torden = request()->get('torden');
                            $torden = !$torden || $torden == 'ASC' ? 'DESC' : 'ASC';

                            // Iconos orden
                            $estiloAsc = '&#xf15d;';
                            $estiloDesc = '&#xf881;';

                            // Orden campos
                            foreach ($campos as $campo) {
                                ${'estilo' . ucfirst($campo)} = '';
                                ${'tOrden' . ucfirst($campo)} = '';

                                if ($orden == $campo) {
                                    ${'estilo' . ucfirst($campo)} = $torden == 'DESC' ? $estiloAsc : $estiloDesc;
                                    ${'tOrden' . ucfirst($campo)} = '&torden=' . $torden;
                                }
                            }

                        @endphp
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.users') }}?orden=name{!! $tOrdenName . $link !!}"
                                    class="flex items-center">
                                    <span>Nombre</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloName !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.users') }}?orden=email{!! $tOrdenEmail . $link !!}"
                                    class="flex items-center">
                                    <span>Email</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloEmail !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.users') }}?orden=telefono{!! $tOrdenTelefono . $link !!}"
                                    class="flex items-center">
                                    <span>Teléfono</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloTelefono !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.users') }}?orden=rol{!! $tOrdenRol . $link !!}"
                                    class="flex items-center">
                                    <span>Rol</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloRol !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr
                                class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a>
                                </th>

                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $user->telefono }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $user->rol }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <a href="{{ route('admin.direcciones.ver-direcciones', $user) }}" class="text-xl text-emerald-400">
                                                <i class="fa-solid fa-address-book"></i>
                                            </a>
                                        </div>
                                        <span class="px-1 text-gray-400 select-none">|</span>
                                        <div>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-xl text-blue-400"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        </div>
                                        <span class="px-1 text-gray-400 select-none">|</span>
                                        <div>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('¿Quieres eliminar el usuario seleccionado?')"
                                                    class="text-xl text-red-400" type="submit">
                                                    <i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="bg-slate-300 px-6 py-4 w-full">
                {{ $users->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
