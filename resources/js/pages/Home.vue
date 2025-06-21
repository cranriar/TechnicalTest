<template>
  <div class="mt-5">
    <Tabs>
      <template #inicio>
        <Greeting></Greeting>
      </template>

      <template #datos-api>
        <DataTable
            url="/api/character-api"
            :editable="false"
            :columns="{
                id: 'ID',
                name: 'Nombre',
                status: 'Estado',
                species: 'Especie',
                image: 'Imagen',
            }"
        ></DataTable>
      </template>

      <template #datos-bd>
        <DataTable
            url="/api/character-db"
            :editable="true"
            :columns="{
                id: 'ID',
                name: 'Nombre',
                status: 'Estado',
                species: 'Especie',
                image: 'Imagen',
            }"
        ></DataTable>
      </template>
    </Tabs>
  </div>
  <div>
    <button class="btn btn-primary" @click="mostrar = true">Abrir Modal</button>

    <Modal :show="mostrar" title="Modal Controlado por Props" @close="mostrar = false">
      <template #default>
        <p>¡Contenido dinámico del modal aquí!</p>
      </template>

      <template #footer>
        <button class="btn btn-success" @click="confirmar">Aceptar</button>
        <button class="btn btn-outline-secondary" @click="mostrar = false">Cancelar</button>
      </template>
    </Modal>
  </div>
</template>

<script>
import Tabs from '../components/Tabs.vue';
import Greeting from '../components/Greeting.vue';
import DataTable from '../components/DataTable.vue';
import Modal from '../components/Modal.vue';

export default {
  name: 'Home',
  data() {
    return {
      mostrar: false
    };
  },
  components: {
    Tabs,
    Greeting,
    DataTable,
    Modal
  }
};
</script>
