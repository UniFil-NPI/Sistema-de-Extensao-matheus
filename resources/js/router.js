import { createRouter, createWebHistory } from 'vue-router';
import CadastroAluno from './components/CadastroAluno.vue';

const routes = [
  { path: '/cadastro-aluno', component: CadastroAluno, name: 'CadastroAluno' },
  // Adicione outras rotas aqui
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
