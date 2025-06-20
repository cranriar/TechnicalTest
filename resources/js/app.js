import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import Home from './pages/Home.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

console.log('Vue está cargando...');

const app = createApp({});
app.component('home', Home);
app.mount('#app');
