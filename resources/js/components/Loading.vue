<template>
  <div class="d-flex flex-column align-items-center justify-content-center py-5">
    <!-- Spinner circular con progreso -->
    <div class="position-relative" style="width: 120px; height: 120px;">
      <svg width="120" height="120">
        <!-- Fondo del círculo -->
        <circle
          cx="60" cy="60" r="50"
          stroke="#e0e0e0" stroke-width="10" fill="none"
        />
        <!-- Progreso -->
        <circle
          cx="60" cy="60" r="50"
          :stroke="progressColor"
          stroke-width="10"
          fill="none"
          stroke-linecap="round"
          :stroke-dasharray="circumference"
          :stroke-dashoffset="offset"
          transform="rotate(-90 60 60)"
        />
      </svg>
      <!-- Porcentaje en el centro -->
      <div
        class="position-absolute top-50 start-50 translate-middle fs-4 fw-semibold text-primary"
      >
        {{ porcentaje }}%
      </div>
    </div>

    <!-- Mensaje de progreso -->
    <p class="mt-4 text-muted fs-5 text-center">
      {{ mensajes[indice] }}
    </p>
  </div>
</template>

<script>
export default {
  name: 'LoadingProgress',
  data() {
    return {
      indice: 0,
      mensajes: [
        'Preparando conexión con la API... Esta consulta se realiza solo una vez por día para optimizar velocidad y reducir llamadas individuales por personaje. ¡Todo bajo control!',
        'Consultando múltiples APIs externas... Estamos simulando 100 llamadas individuales para reflejar integraciones reales, pero solo se realiza una vez al día gracias a caché extendido.',
        'Esta aplicación está construida como una experiencia de página única (SPA), lo que permite una navegación más fluida, rápida y sin recargas al cambiar de sección. ',
        'Actualmente la pestaña Datos BD se encuentra vacia. Al finalizar el proceso, tendrás la opción de registrar la información directamente en nuestra base de datos como parte de una acción persistente.',
      ],
      intervalo: null,
      porcentaje: 0
    };
  },
  computed: {
    progressColor() {
      return this.porcentaje < 100 ? '#0d6efd' : '#00bb88';
    },
    circumference() {
      return 2 * Math.PI * 50;
    },
    offset() {
      const ratio = this.porcentaje / 100;
      return this.circumference * (1 - ratio);
    }
  },
  mounted() {
    this.intervalo = setInterval(() => {
      if (this.indice < this.mensajes.length - 1) {
        this.indice++;
        this.porcentaje += 20;
      } else {
        clearInterval(this.intervalo);
        this.porcentaje = 100;
      }
    }, 10000);
  },
  unmounted() {
    clearInterval(this.intervalo);
  }
};
</script>
