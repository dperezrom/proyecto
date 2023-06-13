<script type="text/javascript" src="{{ asset('js/valoraciones/editar-comentario-user.js')}}" defer></script>
@csrf
<div class="sm:mx-5 lg:mx-20 p-5">
    <!-- Volver -->
    <div class="w-full flex justify-center mb-5 pt-5">
        <a href="{{ route('productos.ver-producto', $producto) }}"
           class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
            <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
        </a>
    </div>

    <div class="p-1">
        @error('puntuacion')
        <p class="text-red-500 text-sm mb-5 font-bold text-left">
            {{ $message }}
        </p>
        @enderror
        @error('titulo')
        <p class="text-red-500 text-sm mb-5 font-bold text-left">
            {{ $message }}
        </p>
        @enderror
        @error('comentario')
        <p class="text-red-500 text-sm mb-5 font-bold text-left">
            {{ $message }}
        </p>
        @enderror
    </div>
    <div class="w-auto bg-white dark:bg-gray-700 border dark:border-gray-500 border-x p-3 md:p-5 rounded-t-lg">
        <article>
            <div class="text-xl font-bold text-center">{{ $producto->denominacion }}</div>
            <div class="flex flex-wrap">
                <input type="hidden" name="producto_id" id="producto_id" value="{{ $producto->id }}">
                <div class="flex items-center mb-1">
                    <label id="label_puntuacion" for="puntuacion" class="text-gray-800 dark:text-gray-200 pr-1">Valoración:</label>
                    @if(!empty($valoracion->id))
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
                    @endif
                </div>

                <select name="puntuacion" id="puntuacion" class="text-sm mr-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500" required>
                    <option value = "" {{ $valoracion->puntuacion == '' ? 'selected' : '' }}></option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ $valoracion->puntuacion == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>

            </div>
            @if($valoracion == null)
                <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                    <p>Comentado en:
                        <span
                            class="text-gray-800 dark:text-gray-200">{{ $valoracion->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</span>
                    </p>
                    @if ($valoracion->created_at != $valoracion->updated_at)
                        <p>Última modificación:
                            <span
                                class="text-gray-800 dark:text-gray-200">{{ $valoracion->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</span>
                        </p>
                    @endif
                </footer>
            @endif
            <div class="pb-3">
                <label id="label_titulo" for="titulo" class="text-gray-800 dark:text-gray-200">Título:</label>
                <input type="text" name="titulo" id="titulo"
                       class="w-full bg-gray-50 border border-gray-300 text-gray-800 font-semibold sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                       required maxlength="50" placeholder="Título" value="{{ old('titulo', $valoracion->titulo) }}">
            </div>

            <div class="flex justify-between">
                <label id="label_comentario" for="comentario"
                       class="text-gray-800 dark:text-gray-200">Comentario:</label>
                <div id="caracteres_comentario" class="text-sm text-gray-700"></div>
            </div>
            <textarea name="comentario" id="comentario" rows="5" cols="100" required maxlength="250"
                      class="w-full text-gray-500 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 resize-none">{{ old('comentario', $valoracion->comentario) }}</textarea>

        </article>
    </div>
    <!-- Botones -->
    <div class="flex justify-around bg-gray-800 rounded-b-2xl py-5">
        <button type="submit"
                class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-md px-2 py-1 text-center">
            <i class="fa-solid fa-floppy-disk pr-1"></i>Guardar
        </button>

    </div>

</div>
