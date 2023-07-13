@props([
    'lecturas' => [],
])

<div x-data="ComponenteLecturas()" x-init="initialize" class="relative mb-4">
    <label for="lecturas" class="leading-7 text-sm text-gray-600">{{ __('Lecturas') }}</label>

    @error('lecturas')
        <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
    @error('palabrasClave')
        <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror

    <div>
        <div class="block mb-1">
            <label for="palabrasClave" class="leading-7 text-sm text-gray-600">
                Generar una lectura con estas palabras clave:
            </label>
        </div>
        <div class="flex">
            <input x-model="inputPalabrasClave" type="text" id="inputPalabrasClave" name="inputPalabrasClave"
                placeholder="Ejemplo: oso, computadora"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <button id="generarLectura" @click.prevent="generarLectura"
                class="flex-shrink-0 ml-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Generar lectura</span>
            </button>
        </div>
    </div>

    <p class="font-light text-sm mt-3">
        Lecturas generadas:
    </p>

    <template x-for="(lectura, index) in lecturasGeneradas" :key="lectura.id">
        <div class="block mb-5">
            <div class="block w-full font-bold text-sm">
                Lectura sobre: <span x-text="lectura.palabrasClave"></span> &nbsp;
                <button type="button" title="Eliminar lectura"
                    @click.prevent="removeLectura(`${lectura.id}`, `${lectura.palabrasClave}`)"
                    class="text-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2  dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                    Eliminar
                </button>
            </div>
            <div x-text="lectura.texto"
                class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <input type="hidden" name="lecturas[]" required :value="lectura.texto" />
            <input type="hidden" name="palabrasClave[]" required :value="lectura.palabrasClave" />
        </div>
    </template>
</div>


<script>
    function ComponenteLecturas() {
        return {
            inputPalabrasClave: "",
            lecturasGeneradas: [],

            initialize() {
                var palabrasClave = "";
                var texto = "";
                var id = 0;

                @foreach ($lecturas as $lectura)
                    palabrasClave = "{{ $lectura->palabras_clave }}";
                    texto = "{{ $lectura->parrafo }}";
                    id = this.lecturasGeneradas.length;
                    this.lecturasGeneradas.push({
                        id: id,
                        palabrasClave: palabrasClave,
                        texto: texto,
                    });
                @endforeach
            },

            removeLectura(id, palabrasClave) {
                if (confirm("¿Eliminar la lectura sobre " + palabrasClave + "?")) {
                    this.lecturasGeneradas = this.lecturasGeneradas.filter(function(lectura) {
                        return lectura.id != id;
                    });
                }
            },

            generarLectura() {
                var data = {
                    palabrasClave: this.inputPalabrasClave,
                };
                axios.get('/sanctum/csrf-cookie')
                    .then((res) => {
                        axios.post('/api/generar-lectura', data)
                            .then((response) => {
                                var id = this.lecturasGeneradas.length;
                                this.lecturasGeneradas.unshift({
                                    id: id,
                                    palabrasClave: response.data.data.palabrasClave,
                                    texto: response.data.data.texto,
                                });
                                this.inputPalabrasClave = "";
                            })
                            .catch(function(error) {
                                console.log("ERROR " +error);
                            });
                    })
                    .catch(function(error) {
                        console.log("ERROR " + error);
                    });
            },
        };
    }
</script>
