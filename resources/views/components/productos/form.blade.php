<script type="text/javascript" src="{{ asset('js/productos/form.js')}}" defer></script>

@csrf
<div class="sm:mx-5 lg:mx-20 bg-emerald-500 p-5">
    <div class="bg-gray-700 p-2 rounded-t-xl py-5 border-gray-400 border-b-4">
        <!-- Imagen -->
        <script>
            function imageViewer(img = '') {
                return {
                    imageUrl: img,

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            }
        </script>

        <div x-data="imageViewer('/images/productos/{{ old('imagen', $producto->imagen) ?: 'default.png' }}')" class="mb-5 w-full">
            <!-- Mostrar imagen -->
            <template x-if="imageUrl">
                <img :src="imageUrl" class="object-contain h-80 w-full">
            </template>

            <template x-if="!imageUrl">
                <div class="border rounded border-gray-200 bg-gray-100" style="width: 150px; height: 150px;"></div>
            </template>

            <!-- Input imagen -->
            <input name="imagen" id="imagen" type="file" accept="image/*" @change="fileChosen" class="hidden">
            <div class="w-full flex justify-center">
                <label for="imagen"
                    class="inline-flex justify-self-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 cursor-pointer">
                    Añadir foto
                </label>
            </div>
        </div>

        <!-- Denominación -->
        <div class="mb-2 p-2">
            <label id="label_denominacion" for="denominacion"
                class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Denominación:
            </label>

            <input type="text" name="denominacion" id="denominacion"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                required maxlength="30" pattern="^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+"
                value="{{ old('denominacion', $producto->denominacion) }}">
        </div>
        <div>
            @error('denominacion')
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
                required maxlength="255" value="{{ old('descripcion', $producto->descripcion) }}">
        </div>
        <div>
            @error('descripcion')
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-2 p-2">
            <label id="label_precio" for="precio" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Precio:
            </label>

            <input type="text" name="precio" id="precio" step="any" min="0" maxlength="7" max="9999" pattern="^[0-9]{0,4}(\.[0-9]{0,2})?$" required
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                value="{{ old('precio', $producto->precio) ?: 0 }}">

        </div>

        @error('precio')
            <div>
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            </div>
        @enderror


        <!-- IVA -->
        <div class="mb-2 p-2">
            <label id="label_iva" for="iva" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                IVA:
            </label>

            <select name="iva" id="iva"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                <option value=21 {{ old('iva', $producto->iva) == 21 ? 'selected' : '' }}>21%</option>
                <option value=10 {{ old('iva', $producto->iva) == 10 ? 'selected' : '' }}>10%</option>
                <option value=4 {{ old('iva', $producto->iva) == 4 ? 'selected' : '' }}>4%</option>
            </select>

        </div>

        @error('iva')
            <div>
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            </div>
        @enderror


        <!-- Stock -->
        <div class="mb-2 p-2">
            <label id="label_stock" for="stock" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Stock:
            </label>

            <input type="number" name="stock" id="stock" min="0" max="999999" pattern="^[0-9]+" required
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                value="{{ old('stock', $producto->stock) ?: 0 }}">

        </div>

        @error('stock')
            <div>
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            </div>
        @enderror


        <!-- Activo -->
        <div class="mb-2 p-2 flex items-center justify-items-start">
            <label id="label_activo" for="activo" class="text-sm font-bold text-white mr-3 sm:w-28 inline-block">
                Activo:
            </label>

            <label class="inline-flex content-center relative cursor-pointer">
                <input type="checkbox" name="activo" value="t" class="sr-only peer w-full"
                    {{ old('activo', $producto->activo) == 't' ? 'checked' : '' }}>
                <div
                    class="w-11 h-6 bg-gray-200 rounded-full peer dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-400">
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
            </label>
        </div>

        @error('activo')
            <div>
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            </div>
        @enderror


        <!-- Descuento -->
        <div class="mb-2 p-2">
            <label id="label_descuento" for="descuento" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Descuento:
            </label>

            <input type="number" name="descuento" id="descuento" min="0" max="100" pattern="^[0-9]{0-3}$" required
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                value="{{ old('descuento', $producto->descuento) ?: 0 }}">

        </div>

        @error('descuento')
            <div>
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            </div>
        @enderror


        <!-- Categoría -->
        <div class="mb-2 p-2">
            <label id="label_categoria_id" for="categoria_id"
                class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Categoría:
            </label>

            <select name="categoria_id" id="categoria_id" required
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                <option value=""> Seleccione una categoría</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('categoria_id', $producto->categoria_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}</option>
                @endforeach
            </select>

        </div>

        @error('categoria_id')
            <div>
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            </div>
        @enderror

        @if ($producto->created_at != null)
        <!-- Fecha creación -->
        <div class="mb-2 p-2 sm:flex sm:items-center">
            <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Creado en:
            </label>
            <div class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                {{ $producto->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
            </div>
        </div>

        <!-- Fecha actualización -->
        <div class="mb-2 p-2 sm:flex sm:items-center">
            <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Modificado en:
            </label>
            <div class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                {{ $producto->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Botones -->
    <div class="flex justify-around bg-gray-800 rounded-b-2xl py-5">
        <button type="submit" id="producto-submit"
            class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-md px-2 py-1 text-center"><i
                class="fa-solid fa-floppy-disk pr-1"></i>Guardar</button>

        <a href="/productos"
            class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1"><i
                class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver</a>

    </div>

</div>
