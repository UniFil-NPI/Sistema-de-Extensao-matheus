<template>
  <div class="container">
    <!-- Faixa laranja no topo -->
    <div class="orange-bg">
      <h1 style="font-size: 3rem;">Gerenciar Projetos</h1>
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
        <p><strong>Nota:</strong> {{ projeto.nota ?? 'Não avaliado' }}</p> <!-- Exibe a nota -->
        <button @click="avaliarProjeto(projeto)">Avaliar Projeto</button>
      </div>
    </div>
  </div>

  <!-- Modal de Avaliação -->
<div v-if="mostrarModal" class="modal-overlay">
  <div class="modal-content">
    <h3 class="modal-title">Avaliar Projeto</h3>
    
    <div class="modal-body">
      <p><strong>Título:</strong> {{ projetoSelecionado?.titulo }}</p>
      <p><strong>Aluno:</strong> {{ projetoSelecionado?.nomeAluno }}</p>
      
      <label for="nota">Nota:</label>
      <input v-model="nota" type="number" id="nota" step="0.1" min="0" max="10" />
    </div>
    
    <div class="modal-buttons">
      <button @click="salvarNota" class="btn btn-save">Salvar</button>
      <button @click="fecharModal" class="btn btn-cancel">Cancelar</button>
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
const listaProjetos = ref([]); // Lista de projetos


const fetchListaProjetos = async () => {
    try {
        const response = await axios.get('/projetos');
        listaProjetos.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar projetos:', error);
    }
};

const filteredListaProjetos = computed(() => {
    let filteredList = listaProjetos.value;
    if (searchProjeto.value) {
        filteredList = filteredList.filter(projeto =>
            projeto.nome.toLowerCase().includes(searchProjeto.value.toLowerCase())
        );
    }
    return filteredList.sort((a, b) => a.nome.localeCompare(b.nome));
});

const searchProjeto = async () => {
    await fetchListaProjetos(); // Buscar projetos sempre que uma nova pesquisa for realizada
};
const openProjetosModal = () => {
    fetchListaProjetos(); // Carregar os projetos
    isProjetosModalOpen.value = true;
};

const closeProjetosModal = () => {
    isProjetosModalOpen.value = false;
};


function fetchProjects() {
  Inertia.get('/gerenciarProjetos', { search: searchQuery.value }, {
    preserveState: true, // Preserva o estado atual da página
    onSuccess: (page) => {
      projetos.value = page.props.projetos;
    },
  });
}



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
        fetchProjects();
        fecharModal();
      },
    });
  }
</script>

<style scoped>
/* Estilos para o modal */
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
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 10px;
  width: 350px;
  max-width: 90%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  text-align: left;
}

.modal-title {
  font-size: 1.5rem;
  margin-bottom: 10px;
  color: #333;
  text-align: center;
}

.modal-body p {
  margin: 10px 0;
  font-size: 1rem;
}

label {
  display: block;
  margin-top: 15px;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="number"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
  box-sizing: border-box;
}

/* Botões */
.modal-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.btn {
  padding: 10px 15px;
  font-size: 1rem;
  border-radius: 4px;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease;
}

.btn-save {
  background-color: #4caf50;
  color: white;
}

.btn-save:hover {
  background-color: #45a049;
}

.btn-cancel {
  background-color: #f44336;
  color: white;
}

.btn-cancel:hover {
  background-color: #d32f2f;
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