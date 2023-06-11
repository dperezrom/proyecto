<script type="text/javascript" src="{{ asset('js/direcciones/form.js') }}" defer></script>
@csrf

<!-- Volver -->
<div class="w-full flex justify-center pb-5 mt-5 ">
    <a href="{{ route('direcciones.mis-direcciones') }}"
       class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
        <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
    </a>
</div>

<div class="bg-gray-700 dark:bg-gray-700 p-2 rounded-t-md py-5 border-gray-400 border-b-4 md:p-5">
    <!-- Nombre -->
    <div class="mb-2 p-2">
        <label id="label_nombre" for="nombre" class="text-sm font-bold text-white mr-3 w-28 inline-block pb-2">
            Nombre:
        </label>

        <input type="text" name="nombre" id="nombre"
               class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-96"
               required autofocus autocomplete="nombre" placeholder="Nombre y apellido" maxlength="50"
               pattern="^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+"
               value="{{ old('nombre', $direccion->nombre) }}">
    </div>

    @error('nombre')
    <div>
        <p class="text-red-500 text-sm mb-5 text-center">
            {{ $message }}
        </p>
    </div>
    @enderror

    <!-- Teléfono -->
    <div class="mb-2 p-2">
        <label id="label_telefono" for="telefono" class="text-sm font-bold text-white mr-3 w-28 inline-block pb-2">
            Teléfono:
        </label>
        <input type="text" name="telefono" id="telefono"
               class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-96"
               required autofocus placeholder="6XXXXXXXX" maxlength="9" pattern="^[1-9]\d{8}$"
               value="{{ old('telefono', $direccion->telefono) }}">

    </div>

    @error('telefono')
    <div>
        <p class="text-red-500 text-sm mb-5 text-center">
            {{ $message }}
        </p>
    </div>
    @enderror

    <!-- Calle -->
    <div class="mb-2 p-2">
        <label id="label_calle" for="calle" class="text-sm font-bold text-white mr-3 w-28 inline-block pb-2">
            Calle:
        </label>

        <input type="text" name="calle" id="calle"
               class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-96"
               required autofocus autocomplete="calle" placeholder="Calle" maxlength="50"
               value="{{ old('calle', $direccion->calle) }}">
    </div>

    @error('calle')
    <div>
        <p class="text-red-500 text-sm mb-5 text-center">
            {{ $message }}
        </p>
    </div>
    @enderror

    <!-- Ciudad -->
    <div class="mb-2 p-2">
        <label id="label_ciudad" for="ciudad" class="text-sm font-bold text-white mr-3 w-28 inline-block pb-2">
            Ciudad:
        </label>

        <input type="text" name="ciudad" id="ciudad"
               class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-96"
               required autofocus autocomplete="ciudad" placeholder="Ciudad" maxlength="50"
               pattern="^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+"
               value="{{ old('ciudad', $direccion->ciudad) }}">
    </div>

    @error('ciudad')
    <div>
        <p class="text-red-500 text-sm mb-5 text-center">
            {{ $message }}
        </p>
    </div>
    @enderror

    <!-- Provincia -->
    <div class="mb-2 p-2">
        <label id="label_provincia" for="provincia" class="text-sm font-bold text-white mr-3 w-28 inline-block pb-2">
            Provincia:
        </label>

        <input type="text" name="provincia" id="provincia"
               class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-96"
               required autofocus autocomplete="provincia" placeholder="Provincia" maxlength="50"
               pattern="^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+"
               value="{{ old('provincia', $direccion->provincia) }}">
    </div>

    @error('provincia')
    <div>
        <p class="text-red-500 text-sm mb-5 text-center">
            {{ $message }}
        </p>
    </div>
    @enderror

    <!-- Código Postal -->
    <div class="mb-2 p-2">
        <label id="label_cp" for="cp" class="text-sm font-bold text-white mr-3 w-28 inline-block pb-2">
            Código Postal:
        </label>

        <input type="text" name="cp" id="cp"
               class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-96"
               required autofocus autocomplete="cp" placeholder="XXXXX" maxlength="5" pattern="^\d{5}$"
               value="{{ old('cp', $direccion->cp) }}">
    </div>

    @error('cp')
    <div>
        <p class="text-red-500 text-sm mb-5 text-center">
            {{ $message }}
        </p>
    </div>
    @enderror

    <!-- Instrucción -->
    <div class="mb-2 p-2">
        <div class="flex justify-between">
            <label id="label_instruccion" for="instruccion"
                   class="text-sm font-bold text-white mr-3 w-28 inline-block pb-2">
                Instrucción:
            </label>
            <div id="caracteres_instruccion" class="text-sm text-white"></div>
        </div>

        <textarea name="instruccion" id="instruccion" rows="5" maxlength="250"
                  class="w-full text-gray-500 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 resize-none">{{ old('instruccion', $direccion->instruccion) }}</textarea>
    </div>

    @error('instruccion')
    <div>
        <p class="text-red-500 text-sm mb-5 text-center">
            {{ $message }}
        </p>
    </div>
    @enderror
</div>

<!-- Botones -->
<div class="flex justify-center bg-gray-800 rounded-b-md py-5">
    <button type="submit" id="user-submit"
            class="text-gray-800 bg-yellow-300 hover:bg-yellow-400 focus:ring-2 focus:ring-yellow-300 font-medium rounded-md px-2 py-1 text-center">
        Añadir dirección
    </button>
</div>
