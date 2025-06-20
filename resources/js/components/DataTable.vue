<template>
    <div>
        <div v-if="data.length" class="align-items-center d-flex flex-column gap-3">
            <button class="btn btn-primary btn-lg mb-3 d-flex align-items-center gap-2" @click="migrateData">
                <svg width="25" height="50" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
                    <!-- Disquete 1 - Azul rey -->
                    <rect x="20" y="20" width="160" height="60" rx="8" fill="#0033A0" stroke="#000" stroke-width="1" />
                    <rect x="40" y="35" width="30" height="15" fill="#ccc" />
                    <rect x="80" y="35" width="80" height="10" fill="#fff" />

                    <!-- Disquete 2 - Azul cielo -->
                    <rect x="20" y="90" width="160" height="60" rx="8" fill="#87CEEB" stroke="#000" stroke-width="1" />
                    <rect x="40" y="105" width="30" height="15" fill="#ccc" />
                    <rect x="80" y="105" width="80" height="10" fill="#fff" />

                    <!-- Disquete 3 - Azul rey -->
                    <rect x="20" y="160" width="160" height="60" rx="8" fill="#0033A0" stroke="#000" stroke-width="1" />
                    <rect x="40" y="175" width="30" height="15" fill="#ccc" />
                    <rect x="80" y="175" width="80" height="10" fill="#fff" />

                    <!-- Disquete 4 - Azul cielo -->
                    <rect x="20" y="230" width="160" height="60" rx="8" fill="#87CEEB" stroke="#000" stroke-width="1" />
                    <rect x="40" y="245" width="30" height="15" fill="#ccc" />
                    <rect x="80" y="245" width="80" height="10" fill="#fff" />
                </svg>
                Migrar información
            </button>
        </div>
        <CharacterModal
            :visible="modalVisible"
            :character="characterSeleccionado"
            @close="modalVisible = false"
        />
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th v-for="(label, key) in columns" :key="key">{{ label }}</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.id">
                    <td v-for="(label, key) in columns" :key="key">
                        <span v-if="label === 'Imagen'">
                            <img :src="item[key]" alt="Imagen" class="w-25 rounded-5 shadow-lg" />
                        </span>
                        <span v-else>
                            {{ item[key] }}
                        </span>
                    </td>
                    <td>
                        <button v-if="editable" class="btn btn-sm btn-warning"
                            @click="$emit('edit', item)">Editar</button>
                        <button type="button"
                            class="btn btn-outline-primary d-inline-flex align-items-center gap-2 rounded-pill shadow-sm px-4 py-2"
                            @click="mostrarDetalle(item)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z" />
                            </svg>
                            Ver detalle
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <p v-if="loading">Cargando datos...</p>
        <p v-if="error" class="text-danger">{{ error }}</p>
        <div v-if="!data.length && !loading" class="align-items-center d-flex flex-column gap-3">
            <button class="btn btn-success btn-lg d-flex align-items-center gap-2" @click="cargarDatos">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-diagram-3-fill" viewBox="0 0 16 16">
                    <path
                        d="M4.5 0a1.5 1.5 0 0 1 1.5 1.5V2h4v-.5a1.5 1.5 0 0 1 3 0V4a1 1 0 0 1-1 1h-2v2.09A2.5 2.5 0 1 1 7 9V7H5a1 1 0 0 1-1-1V1.5A1.5 1.5 0 0 1 4.5 0z" />
                    <path
                        d="M1 13.5A2.5 2.5 0 1 1 3.5 16 2.5 2.5 0 0 1 1 13.5zM12.5 13.5A2.5 2.5 0 1 1 15 16a2.5 2.5 0 0 1-2.5-2.5z" />
                </svg>
                Cargar personajes
            </button>
        </div>
        <Loading v-if="loading"></Loading>
    </div>
    
</template>

<script>
import { onActivated } from 'vue';
import Loading from './Loading.vue';
import CharacterModal from './CharacterModal.vue';
export default {
    components: { Loading, CharacterModal },
    name: 'DataTable',
    props: {
        url: {
            type: String,
            required: true
        },
        editable: {
            type: Boolean,
            default: false
        },
        columns: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            data: [],
            loading: false,
            error: null,
            modalVisible: false,
            characterSeleccionado: null
        };
    },
    mounted() {
        // this.fetchData();
        console.log('DataTableOk...')
    },
    methods: {
        async fetchData() {
            try {
                const res = await fetch(this.url);
                if (!res.ok) throw new Error('Error al cargar los datos');
                const json = await res.json();
                this.data = json.data ?? json; // Por si es API tipo Laravel Resource
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },
        async cargarDatos() {
            this.loading = true;
            this.error = null;
            try {
                const res = await fetch(this.url);
                if (!res.ok) throw new Error('Error al cargar los datos');
                const json = await res.json();
                this.data = json.data ?? json; // Por si es API tipo Laravel Resource
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }

        },
        async migrateData() {
            console.log('Migrando datos...');
            this.loading = true;
            this.error = null;
            try {
                const res = await fetch('/api/migrate-data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.data)
                });
                if (!res.ok) throw new Error('Error al migrar los datos');
                const json = await res.json();
                this.data = json.data ?? json; // Por si es API tipo Laravel Resource
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },
         mostrarDetalle(char) {
            this.characterSeleccionado = char;
            this.modalVisible = true;
        }
    }
};
</script>
