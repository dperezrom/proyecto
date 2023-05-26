<x-app-layout>
    @section('title', 'Ver valoraciones - ' . $producto->denominacion)
    <div class="w-full">
        <!-- Volver -->
        <div class="w-full flex justify-center mb-5 pt-5">
            <a href="{{ route('admin.productos') }}"
                class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
                <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
            </a>
        </div>

        @if (count($producto->valoraciones) < 1)
            <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white text-center">
                <span>No hay comentarios para éste producto.</span>
            </div>
        @else
            <div class="px-5">
                <div x-data class="mb-5">
                    <form action="{{ route('admin.valoraciones.ver-valoraciones', $producto) }}" name="orden_form" method="get">
                        <select name="orden" id="orden" @change="orden_form.submit()"
                            class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer">
                            <option value='desc' {{ request()->query('orden') == 'desc' ? 'selected' : '' }}>Más recientes</option>
                            <option value='asc' {{ request()->query('orden') == 'asc' ? 'selected' : '' }}>Más antiguas</option>
                        </select>
                    </form>
                </div>

                @foreach ($paginador as $valoracion)
                    <div class="w-auto bg-white dark:bg-gray-700 border mb-5 p-3 md:p-5 rounded-lg">
                        <article>
                            <div class="flex items-center space-x-4">
                                <div class="space-y-1 font-medium dark:text-white">
                                    <p class="break-all">
                                        <span class="mr-2">{{ $valoracion->user->name }}</span>
                                        <a href="{{ route('admin.users.show', $valoracion->user_id) }}">
                                            <span
                                                class="text-sm text-gray-500 dark:text-gray-200 hover:text-emerald-500 ">({{ $valoracion->user->email }})</span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg aria-hidden="true"
                                        class="w-5 h-5 {{ $valoracion->puntuacion >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <title>{{ $i }} star</title>
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor

                                <h3 class="ml-2 text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $valoracion->titulo }}
                                </h3>
                            </div>
                            <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                                <p>Comentado en: {{$valoracion->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</p>
                                @if ($valoracion->created_at != $valoracion->updated_at)
                                <p>Última modificación: {{$valoracion->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</p>
                                @endif
                            </footer>
                            <p class="mb-2 font-light text-gray-500 dark:text-gray-400">{{ $valoracion->comentario }}
                            </p>

                            <aside>
                                <div class="flex items-center mt-3 space-x-3">
                                    <a href="{{ route('admin.valoraciones.edit', $valoracion) }}"
                                        class="px-4 py-1 text-sm text-white bg-yellow-400 hover:bg-yellow-500 rounded">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="#" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            onclick="return confirm('¿Quieres eliminar la valoración seleccionada?')"
                                            class="px-4 py-1 text-sm text-white bg-red-400 hover:bg-red-500 rounded"
                                            type="submit"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </aside>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="bg-slate-300 dark:bg-gray-800 sm:mx-5 px-6 py-4">
                {{ $paginador->links('vendor.pagination.tailwind') }}
            </div>
        @endif

    </div>

</x-app-layout>
