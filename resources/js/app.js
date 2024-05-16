
import './bootstrap';

import { createApp } from 'vue';
import App from './components/App.vue';
import CadastroAluno from './components/CadastroAluno.vue';
import router from './router';
const app = createApp();

app.component('app', App);
app.component('CadastroAluno', CadastroAluno);


app.mount('#app');


