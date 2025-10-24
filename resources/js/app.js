import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import '../css/app.css'; // ✅ Agrega esta línea

const app = createApp(App);
app.mount('#app');