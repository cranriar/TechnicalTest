<template>
  <div>
    <ul class="nav nav-tabs">
      <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
        <button
          class="nav-link"
          :class="{ active: activeTab === index }"
          @click="activeTab = index"
        >
          {{ tab.label }}
        </button>
      </li>
    </ul>

    <div class="tab-content border-start border-end border-bottom p-3">
      <div v-for="(tab, index) in tabs" :key="index" v-show="activeTab === index">
        <slot :name="tab.slot" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Tabs',
  data() {
    return {
      activeTab: 0,
      tabs: [
        { label: 'Inicio', slot: 'inicio' },
        { label: 'Datos Api', slot: 'datos-api' },
        { label: 'Datos BD', slot: 'datos-bd' }
      ]
    };
  }
};
</script>
