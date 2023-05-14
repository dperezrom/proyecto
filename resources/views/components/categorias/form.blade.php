<script type="text/javascript" src="{{ asset('js/categorias/form.js')}}" defer></script>
@csrf
<div class="sm:mx-5 lg:mx-20 bg-emerald-500 p-5">
    <div class="bg-gray-700 p-2 rounded-t-xl py-5 border-gray-400 border-b-4">
        <!-- Nombre -->
        <div class="mb-2 p-2">
            <label id="label_nombre" for="nombre" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Nombre:
            </label>

            <input type="text" name="nombre" id="nombre"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                required maxlength="30" pattern="^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+"
                value="{{ old('nombre', $categoria->nombre) }}">
        </div>
        <div>
            @error('nombre')
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-2 p-2">
            <label id="label_descripcion" for="descripcion" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Descripción:
            </label>
            <input type="text" name="descripcion" id="descripcion"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                required maxlength="255"
                value="{{ old('descripcion', $categoria->descripcion) }}">
        </div>
        <div>
            @error('descripcion')
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            @enderror
        </div>

        @if ($categoria->created_at != null)
        <!-- Fecha creación -->
        <div class="mb-2 p-2 sm:flex sm:items-center">
            <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Creado en:
            </label>
            <div class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                {{ $categoria->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
            </div>
        </div>

        <!-- Fecha actualización -->
        <div class="mb-2 p-2 sm:flex sm:items-center">
            <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Modificado en:
            </label>
            <div class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                {{ $categoria->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Botones -->
    <div class="flex justify-around bg-gray-800 rounded-b-2xl py-5">
        <button type="submit"
            class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-md px-2 py-1 text-center"><i class="fa-solid fa-floppy-disk pr-1"></i>Guardar</button>

        <a href="/categorias"
            class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1"><i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver</a>

    </div>

</div>
