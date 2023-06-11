<script type="text/javascript" src="{{ asset('js/impuestos/form.js')}}" defer></script>
@csrf

<div class="w-full flex justify-center mb-5">
    <a href="{{ route('admin.impuestos') }}"
       class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
        <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
    </a>
</div>

<div class="sm:mx-5 lg:mx-20 bg-emerald-500 p-5 mb-5">
    <div class="bg-gray-700 p-2 rounded-t-xl py-5 border-gray-400 border-b-4">
        <!-- Descripción -->
        <div class="mb-2 p-2">
            <label id="label_descripcion" for="descripcion" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Descripción:
            </label>
            <input type="text" name="descripcion" id="descripcion"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                required maxlength="50"
                value="{{ old('descripcion', $impuesto->descripcion) }}">
        </div>
        <div>
            @error('descripcion')
                <p class="text-red-500 text-sm mb-5 text-center">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Porcentaje -->
        <div class="mb-2 p-2">
            <label id="label_porcentaje" for="porcentaje" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Porcentaje:
            </label>

            <input type="number" name="porcentaje" id="porcentaje"
                   class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                   required pattern="^[0-9]+$" min="0" max="100"
                   value="{{ old('porcentaje', $impuesto->porcentaje) }}">
        </div>
        <div>
            @error('porcentaje')
            <p class="text-red-500 text-sm mb-5 text-center">
                {{ $message }}
            </p>
            @enderror
        </div>

        @if ($impuesto->created_at != null)
        <!-- Fecha creación -->
        <div class="mb-2 p-2 sm:flex sm:items-center">
            <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Creado en:
            </label>
            <div class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                {{ $impuesto->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
            </div>
        </div>

        <!-- Fecha actualización -->
        <div class="mb-2 p-2 sm:flex sm:items-center">
            <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Modificado en:
            </label>
            <div class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                {{ $impuesto->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Botones -->
    <div class="flex justify-center bg-gray-800 rounded-b-2xl py-5">
        <button type="submit"
            class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-md px-2 py-1 text-center"><i class="fa-solid fa-floppy-disk pr-1"></i>Guardar</button>
    </div>

</div>
