<template>
    <div>
        <!-- Barra de navegação -->
        <div class="navbar">
            <!-- Substituindo o texto pelo logo -->
            <div class="logo-container">
                <img src="/images/logo.png" alt="Logo do Sistema de Extensão Curricular" class="logo-image" />
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="sidebar">
                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#" @click="openAlunosModal">Alunos</a></li> <!-- Botão Alunos -->
                    <li><a href="#" @click="toggleAtividades">Atividades</a></li>
                    <li><a href="/gerenciarProjetos">Projetos</a></li>
                </ul>
            </div>

            <!-- Conteúdo principal -->
            <div class="main-content">
                <h1>Bem-vindo ao UniExtension</h1>
                <br>

                <!-- Botão para criar nova atividade -->
                <button @click="showCreateModal = true" class="btn-criar-atividade">Criar Nova Atividade</button>

                <!-- Lista de atividades -->
                <div v-if="showAtividades" class="atividades-list">
                    <h2>Lista de Atividades</h2>
                    <ul>
                        <li v-for="atividade in atividades" :key="atividade.id" @click="openAtividadeModal(atividade)" :class="{ completed: atividade.concluida }">
                            <h3>{{ atividade.titulo }}</h3>
                            <p>{{ atividade.descricao }}</p>
                            <p>Data de Entrega: {{ formatDate(atividade.dataEntrega) }}</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Modal de Alunos -->
            <div v-if="isAlunosModalOpen" class="modal">
                <div class="modal-content">
                    <span class="close" @click="closeAlunosModal">&times;</span>
                    <h2>Lista de Alunos</h2>
                    <div class="search-form">
                        <form @submit.prevent="searchStudent">
                            <input type="text" v-model="search" class="search-input" placeholder="Digite o nome do aluno">
                            <button type="submit" class="search-button">Pesquisar</button>
                        </form>
                    </div>
                    <table class="alunos-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Fase da Extensão</th>
                                <th>Nome do Projeto</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="aluno in filteredAlunos" :key="aluno.id">
                                <td>{{ aluno.nome }}</td>
                                <td>{{ aluno.email }}</td>
                                <td>{{ aluno.faseExtensao }}</td>
                                <td>{{ aluno.nomeProjeto }}</td>
                                <td>
                                    <button @click="editAluno(aluno)">Editar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
           <!-- Modal para criar nova atividade -->
           <div v-if="showCreateModal" class="modal">
                <div class="modal-content">
                    <span class="close" @click="closeCreateModal">&times;</span>
                    <h2>Criar Nova Atividade</h2>
                    <form @submit.prevent="createAtividade" class="form-container">
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" id="titulo" v-model="novaAtividade.titulo" required>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição:</label>
                            <textarea id="descricao" v-model="novaAtividade.descricao" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="dataEntrega">Data de Entrega:</label>
                            <input type="date" id="dataEntrega" v-model="novaAtividade.dataEntrega" required>
                        </div>

                        <button type="submit" class="submit-btn">Criar Atividade</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

            <!-- Modal de Edição de Aluno -->
            <div v-if="isEditModalOpen" class="modal">
                <div class="modal-content modal-content-editar-aluno">
                    <span class="close" @click="closeEditModal">&times;</span>
                    <h2>Editar Aluno</h2>
                    <form @submit.prevent="updateAluno">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" v-model="currentAluno.nome" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" v-model="currentAluno.email" required>

                        <label for="faseExtensao">Fase da Extensão:</label>
                        <input type="text" id="faseExtensao" v-model="currentAluno.faseExtensao" required>

                        <label for="nomeProjeto">Nome do Projeto:</label>
                        <input type="text" id="nomeProjeto" v-model="currentAluno.nomeProjeto" required>

                        <button type="submit">Salvar</button>
                    </form>
                </div>
            </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const showAtividades = ref(false);
const atividades = ref([]);
const isAtividadeModalOpen = ref(false);
const showCreateModal = ref(false);
const currentAtividade = ref({});
const novaAtividade = ref({
    titulo: '',
    descricao: '',
    dataEntrega: ''
});

const isAlunosModalOpen = ref(false);
const isEditModalOpen = ref(false);
const alunos = ref([]);
const currentAluno = ref({});
const search = ref('');


const toggleAtividades = () => {
    showAtividades.value = !showAtividades.value;
    if (showAtividades.value) {
        fetchAtividades();
    }
};

const openAlunosModal = () => {
    fetchAlunos();
    isAlunosModalOpen.value = true;
};

const closeAlunosModal = () => {
    isAlunosModalOpen.value = false;
};

const fetchAtividades = async () => {
    try {
        const response = await axios.get('/atividades');
        atividades.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar atividades:', error);
    }
};

const fetchAlunos = async () => {
    try {
        const response = await axios.get('/alunos');
        alunos.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar alunos:', error);
    }
};

const filteredAlunos = computed(() => {
    let filteredList = alunos.value;
    if (search.value) {
        filteredList = filteredList.filter(aluno =>
            aluno.nome.toLowerCase().includes(search.value.toLowerCase())
        );
    }
    return filteredList.sort((a, b) => a.nome.localeCompare(b.nome));
});

const openAtividadeModal = (atividade) => {
    currentAtividade.value = { ...atividade };
    isAtividadeModalOpen.value = true;
};

const closeAtividadeModal = () => {
    isAtividadeModalOpen.value = false;
    currentAtividade.value = {};
};

const createAtividade = async () => {
    try {
        await axios.post('/atividades', novaAtividade.value);
        novaAtividade.value = { titulo: '', descricao: '', dataEntrega: '' };
        showCreateModal.value = false;
        fetchAtividades();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            alert('Data de entrega inválida. Por favor, escolha uma data que seja hoje ou no futuro.');
        } else {
            console.error('Erro ao criar atividade:', error);
        }
    }
};

const closeCreateModal = () => {
    showCreateModal.value = false;
    novaAtividade.value = { titulo: '', descricao: '', dataEntrega: '' };
};

const editAluno = (aluno) => {
    currentAluno.value = { ...aluno };
    isEditModalOpen.value = true;
};

const closeEditModal = () => {
    isEditModalOpen.value = false;
    currentAluno.value = {};
};

const updateAluno = async () => {
    try {
        await axios.put(`/alunos/${currentAluno.value.id}`, currentAluno.value);
        await fetchAlunos();
        closeEditModal();
    } catch (error) {
        console.error('Erro ao atualizar aluno:', error);
    }
};

const removerAluno = async (alunoId) => {
    try {
        await axios.delete(`/alunos/${alunoId}`);
        fetchAlunos();
    } catch (error) {
        console.error('Erro ao remover aluno:', error);
    }
};

const formatDate = (date) => {
    const [year, month, day] = date.split('-');
    return `${day}/${month}/${year}`;
};

onMounted(() => {
    fetchAtividades();
});
</script>



<style scoped>
/* Estilização global */
.container {
    display: flex;
}

.navbar {
    background-color: #F29400;
    color: #fff;
    height: 100px;
    margin-bottom: 20px;
    padding: 10px;
    display: flex;
    justify-content: center;
}

.sidebar {
    width: 200px;
    background-color: #f9f9f9;
    padding: 20px;
    border-right: 1px solid #ddd;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    text-decoration: none;
    color: #333;
}

.main-content {
    flex: 1;
    padding: 20px;
}

.atividades-list {
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.atividades-list ul {
    list-style-type: none;
    padding: 0;
}

.atividades-list li {
    background-color: #f9f9f9;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 4px;
    cursor: pointer;
}

.atividades-list li:hover {
    background-color: #f2f2f2;
}

.atividades-list li.completed {
    background-color: #d4edda;
}

.atividades-list h3 {
    margin: 0 0 10px 0;
}

.atividades-list p {
    margin: 0;
}

.atividades-list p.concluida {
    color: #28a745;
    font-weight: bold;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 1000px;
    max-height: 80%;
    overflow-y: auto;
}

.modal-content .close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

/* Estilo do modal */
.modal {
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content-editar-aluno {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  width: 400px;
  max-width: 90%;
  animation: fadeIn 0.3s ease-in-out;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

h2 {
  margin-top: 0;
  color: #333;
  text-align: center;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
  color: #333;
}

input[type="text"],
input[type="email"],
select {
  width: calc(100% - 20px);
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.save-btn {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
  font-size: 16px;
}

.save-btn:hover {
  background-color: #45a049;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 5px;
}

.form-group input[type="text"],
.form-group input[type="date"],
.form-group textarea {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-group textarea {
    resize: vertical;
}

.submit-btn {
    background-color: #28a745;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.submit-btn:hover {
    background-color: #218838;
}

.alunos-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.alunos-table th, .alunos-table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
    width:100%;
}

.alunos-table th {
    background-color: #f2f2f2;
    width: 100%;
}

.search-form {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.search-input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: calc(100% - 100px);
}

.search-button {
    padding: 8px 20px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

.search-button:hover {
    background-color: #0056b3;
}

.btn-criar-atividade {
    background-color: #28a745;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-bottom: 20px;
}

.btn-criar-atividade:hover {
    background-color: #218838;
}

.logo-container {
    display: flex;
    align-items: center;
    width: 300px;
}

.logo-image {
    max-width: 200px;
    height: auto;
}

</style>
