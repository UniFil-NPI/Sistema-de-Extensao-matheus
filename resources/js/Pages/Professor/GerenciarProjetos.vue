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
        <button @click="avaliarProjeto(projeto)">Avaliar Projeto</button>
      </div>
    </div>
  </div>

  <!-- Modal de Avaliação -->
<div v-if="mostrarModal" class="modal-overlay">
  <div class="modal-content">
    <h3>Avaliar Projeto</h3>
    <p><strong>Título:</strong> {{ projetoSelecionado?.titulo }}</p>
    <p><strong>Aluno:</strong> {{ projetoSelecionado?.nomeAluno }}</p>
    
    <label for="nota">Nota:</label>
    <input v-model="nota" type="number" step="0.1" min="0" max="10" />

    <div class="modal-buttons">
      <button @click="salvarNota">Salvar</button>
      <button @click="fecharModal">Cancelar</button>
    </div>
  </div>
</div>

</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
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

// Variáveis para o modal
const mostrarModal = ref(false);
const projetoSelecionado = ref(null);
const nota = ref(null);

function avaliarProjeto(projeto) {
  projetoSelecionado.value = projeto;
  nota.value = projeto.nota || ''; // Preenche com a nota existente, se houver
  mostrarModal.value = true;
}

function fecharModal() {
  mostrarModal.value = false;
  projetoSelecionado.value = null;
  nota.value = null;
}

function salvarNota() {
    Inertia.post(`/professor/avaliar-projeto/${projetoSelecionado.value.id}`, { nota: nota.value }, {
      onSuccess: () => {
        // Atualiza a nota no frontend
        projetoSelecionado.value.nota = nota.value;
        fecharModal();
      },
    });
  }
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 300px;
  text-align: center;
}

.modal-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}



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