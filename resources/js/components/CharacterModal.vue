<template>
  <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl mx-4 overflow-hidden">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="text-xl font-semibold">{{ character.name }}</h3>
        <button @click="$emit('close')" class="text-gray-600 hover:text-black text-xl font-bold">&times;</button>
      </div>

      <div class="p-4">
        <div class="text-center mb-4">
          <img :src="character.image" :alt="character.name" class="w-48 h-48 rounded-full mx-auto object-cover" />
        </div>
        <ul class="space-y-1 text-sm">
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

      <div class="p-4 border-t text-right">
        <button @click="$emit('close')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    visible: Boolean,
    character: Object
  }
};
</script>
