<script type="text/javascript" src="{{ asset('js/users/form.js') }}" defer></script>

@csrf
<div class="sm:mx-5 lg:mx-20 bg-emerald-500 p-5">
    <div class="bg-gray-700 p-2 rounded-t-xl py-5 border-gray-400 border-b-4">
        <!-- Nombre -->
        <div class="mb-2 p-2">
            <label id="label_name" for="name" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Nombre:
            </label>

            <input type="text" name="name" id="name"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                required autofocus autocomplete="name" placeholder="Nombre y apellido" maxlength="35" minlength="2"
                pattern="^((\s?[a-zA-ZáéíóúÁÉÍÓÚñÑ]+){2,4})" value="{{ old('name', $user->name) }}">
        </div>
        <div>
            @error('name')
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-2 p-2">
            <label id="label_email" for="email" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Email:
            </label>
            <input type="email" name="email" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                required placeholder="ejemplo@gmail.com" maxlength="50" value="{{ old('email', $user->email) }}">
        </div>
        <div>
            @error('email')
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Teléfono -->
        <div class="mb-2 p-2">
            <label id="label_telefono" for="telefono" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Teléfono:
            </label>
            <input type="text" name="telefono" id="telefono"
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                required autofocus placeholder="6XXXXXXXX" maxlength="9" pattern="^[1-9]\d{8}$"
                value="{{ old('telefono', $user->telefono) }}">

        </div>
        <div>
            @error('telefono')
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Rol -->
        <div class="mb-2 p-2">
            <label id="label_rol" for="rol" class="text-sm font-bold text-white mr-3 w-28 inline-block">
                Rol:
            </label>

            <select name="rol" id="rol" required
                class="bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                <option value="usuario" {{ old('rol', $user->rol) == 'usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="admin" {{ old('rol', $user->rol) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>

        </div>

        @error('rol')
            <div>
                <p class="text-red-500 text-sm mb-5 border-y-4 text-center">
                    {{ $message }}
                </p>
            </div>
        @enderror

        @if ($user->created_at != null)
            <!-- Fecha creación -->
            <div class="mb-2 p-2 sm:flex sm:items-center">
                <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                    Creado en:
                </label>
                <div
                    class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                    {{ $user->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
                </div>
            </div>

            <!-- Fecha actualización -->
            <div class="mb-2 p-2 sm:flex sm:items-center">
                <label class="text-sm font-bold text-white mr-3 w-28 inline-block">
                    Modificado en:
                </label>
                <div
                    class="p-2 bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">
                    {{ $user->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Botones -->
    <div class="flex justify-around bg-gray-800 rounded-b-2xl py-5">
        <button type="submit" id="user-submit"
            class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-md px-2 py-1 text-center"><i
                class="fa-solid fa-floppy-disk pr-1"></i>Guardar</button>

        <a href="{{ route('admin.users') }}"
            class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1"><i
                class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver</a>
    </div>

</div>
