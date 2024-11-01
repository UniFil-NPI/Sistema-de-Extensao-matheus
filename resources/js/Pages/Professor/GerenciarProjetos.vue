<template>
  <div class="container">
    <!-- Faixa laranja no topo -->
    <div class="orange-bg">
      <h1>Gerenciar Projetos</h1>
    </div>

    <!-- Campo de busca -->
    <div class="search-bar">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Buscar projeto por título..."
      />
      <button @click="fetchProjects">Buscar</button>
    </div>

    <!-- Lista de projetos -->
    <div class="project-list">
      <div
        v-for="projeto in projetos"
        :key="projeto.id"
        class="project-item"
      >
        <h2>{{ projeto.titulo }}</h2>
        <p><strong>Aluno:</strong> {{ projeto.nomeAluno }}</p>
        <button @click="avaliarProjeto(projeto.id)">Avaliar Projeto</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3'; // Importar para acessar os dados retornados pela Inertia

const { props } = usePage(); // Obter as propriedades passadas pela Inertia
const searchQuery = ref('');
const projetos = ref(props.projetos); // Atribuir os projetos passados pela Inertia

const filteredProjects = computed(() => {
  if (!searchQuery.value) {
    return projetos.value;
  }
  return projetos.value.filter(projeto =>
    projeto.titulo.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

function avaliarProjeto(id) {
  console.log(`Redirecionando para a avaliação do projeto ${id}`);
  // Inertia.visit(`/professor/avaliar-projeto/${id}`);
}
</script>

<style scoped>
.container {
  padding: 20px;
}

.orange-bg {
  background-color: #F29400;
  padding: 20px;
  text-align: center;
  color: #fff;
  margin-bottom: 20px;
}

.search-bar {
  margin-bottom: 30px;
  text-align: center;
}

.search-bar input {
  padding: 10px;
  width: 300px;
  font-size: 16px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.search-bar button {
  padding: 10px 20px;
  margin-left: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  font-size: 16px;
}

.search-bar button:hover {
  background-color: #45a049;
}

.project-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  justify-items: center;
}

.project-item {
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 100%;
  max-width: 400px;
}

.project-item h2 {
  margin-bottom: 10px;
  color: #333;
}

.project-item p {
  margin-bottom: 10px;
  font-size: 16px;
  color: #555;
}

.project-item button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  margin-top: 10px;
  font-size: 16px;
}

.project-item button:hover {
  background-color: #45a049;
}
</style>