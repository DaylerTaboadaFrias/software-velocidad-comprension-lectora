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
            <button id="generarLectura" @click.prevent="generarLectura" x-bind:disabled="cargando"
                class="flex-shrink-0 ml-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <span x-bind:hidden="!cargando">
                    <svg class="inline w-5 h-5 mr-3 text-black animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                </span>
                <svg x-bind:hidden="cargando" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
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
            cargando: false,

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
                
                this.cargando = true;

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
                                this.cargando = false;
                            })
                            .catch(function(error) {
                                this.cargando = false;
                                console.log("ERROR " +error);
                            });
                    })
                    .catch(function(error) {
                        this.cargando = false;
                        console.log("ERROR " + error);
                    });
            },
        };
    }
</script>
