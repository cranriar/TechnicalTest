import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

console.log('Vue está cargando...');

const app = createApp({});
app.component('example-component', ExampleComponent);
app.mount('#app');
