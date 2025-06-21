<template>
    <div>
      <div class="bg-white rounded-lg shadow-lg w-full max-w-xl mx-4 overflow-hidden">

        <div class="p-4">
          <div class="text-center mb-4">
            <img :src="form.image" :alt="form.name" class="w-48 h-48 rounded-full mx-auto object-cover" />
          </div>
          <form v-if="isEditing" @submit.prevent="submitEdit">
            <div class="mb-2">

              <label class="block text-sm font-medium">Nombre</label>
              <input v-model="form.name" class="w-full border rounded px-2 py-1" required />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium">Status</label>
              <input v-model="form.status" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium">Especie</label>
              <input v-model="form.species" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium">Tipo</label>
              <input v-model="form.type" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium">Género</label>
              <input v-model="form.gender" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium">Origen</label>
              <input v-model="form.origin.name" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium">Ubicación</label>
              <input v-model="form.location.name" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium">Imagen (URL)</label>
              <input v-model="form.image" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="flex justify-end space-x-2 mt-4">
              <button type="button" @click="isEditing = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
              <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Guardar</button>
            </div>
          </form>
          <ul v-else class="space-y-1 text-sm">
            <li><strong>Status:</strong> {{ character.status }}</li>
            <li><strong>Species:</strong> {{ character.species }}</li>
            <li><strong>Type:</strong> {{ character.type || 'N/A' }}</li>
            <li><strong>Gender:</strong> {{ character.gender }}</li>
            <li><strong>Origin:</strong> {{ character.origin?.name || 'Desconocido' }}</li>
            <li><strong>Location:</strong> {{ character.location?.name || 'Desconocido' }}</li>
            <li>
              <strong>Episodios:</strong>
              <ul class="pl-5 list-disc max-h-40 overflow-y-auto text-gray-600">
                <li v-for="ep in character.episode" :key="ep">{{ ep }}</li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props: {
    character: Object,
    isEditing: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      form: {
        id: '',
        name: '',
        status: '',
        species: '',
        type: '',
        gender: '',
        origin: { name: '' },
        location: { name: '' },
        image: ''
      }
    };
  },
  watch: {
    character: {
      immediate: true,
      handler(val) {
        if (val) {
          this.form = {
            name: val.name,
            status: val.status,
            species: val.species,
            type: val.type,
            gender: val.gender,
            origin: { name: val.origin?.name || '' },
            location: { name: val.location?.name || '' },
            image: val.image
          };
        }
      }
    }
  },
  methods: {
    startEdit() {
      this.isEditing = true;
    },
    async submitEdit() {
      // Aquí deberías hacer la petición a la API para guardar los cambios
      // Por ejemplo:
      this.form.id = this.character.id; // Asegúrate de incluir el ID del personaje
      await fetch(`/api/update-data`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.form)
      });
      
    }
  }
};
</script>


