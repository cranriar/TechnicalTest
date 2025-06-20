<template>
  <div class="container mt-5">
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
        <h3>Datos en la base de datos</h3>
      </template>
    </Tabs>
  </div>
</template>

<script>
import Tabs from '../components/Tabs.vue';
import Greeting from '../components/Greeting.vue';
import DataTable from '../components/DataTable.vue';

export default {
  components: {
    Tabs,
    Greeting,
    DataTable
  }
};
</script>
