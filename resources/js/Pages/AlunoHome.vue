<template>
    <div>
        <!-- Barra de navegação -->
        <div class="navbar">
       <!-- Substituindo o texto pelo logo -->
       <div class="logo-container">
                <img src="/images/logo.png" alt="Logo do Sistema de Extensão Curricular" class="logo-image" />
            </div>
        </div>

        <!-- Nome do aluno logado -->
        <div class="aluno-info">
                <span>Bem-vindo, {{ aluno.nome }}</span>
            </div>

        <!-- Conteúdo principal -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="sidebar">
                <ul>
                    <li><span class="sidebar-selected">Início</span></li>
                    <li><a href="#" class="sidebar-button" @click="showAtividades = true">Atividades</a></li>
                    <li><a href="#" class="sidebar-button" @click="abrirProjeto">Projeto</a></li>
                    <!---<li><a href="#" @click="redirectToCriarProjeto">Criar Projeto</a></li>-->
                </ul>
            </div>

            <!-- Conteúdo principal -->
            <div class="main-content">
                <h1>Bem-vindo ao Sistema de Extensão Curricular</h1>
                <br>

                <!-- Lista de atividades -->
                <div v-if="showAtividades" class="atividades-list">
                    <h2>Lista de Atividades</h2>
                    <ul>
                        <li v-for="atividade in atividades" :key="atividade.id" @click="openAtividadeModal(atividade)" :class="{ completed: atividade.concluida }">
                            <h3>{{ atividade.titulo }}</h3>
                            <p>{{ atividade.descricao }}</p>
                            <p>Data de Entrega: {{ formatDate(atividade.dataEntrega) }}</p>
                            <p v-if="atividade.concluida" class="concluida">Concluída</p>
                        </li>
                    </ul>
                </div>
            </div>

           <!-- Modal de Atividade -->
<div v-if="isAtividadeModalOpen" class="modal">
    <div class="modal-content">
        <span class="close" @click="closeAtividadeModal">&times;</span>
        <h2>{{ currentAtividade.titulo }}</h2>
        <div class="form-container">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <p class="readonly-text">{{ currentAtividade.descricao }}</p>
            </div>

            <div class="form-group">
                <label for="dataEntrega">Data de Entrega:</label>
                <p class="readonly-text">{{ formatDate(currentAtividade.dataEntrega) }}</p>
            </div>

            <div class="form-group">
                <label for="link">Link para Submissão:</label>
                <input type="url" id="link" v-model="link" required>
            </div>

            <button type="submit" class="submit-btn" @click="submitLink">Enviar</button>
        </div>
    </div>
</div>


        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
import { defineProps } from 'vue';


const showAtividades = ref(false);
const atividades = ref([]);
const isAtividadeModalOpen = ref(false);
const currentAtividade = ref({});
const link = ref('');


const props = defineProps(['aluno']); // Obtendo o aluno como uma prop
//const aluno = ref({}); // Aluno deve ser passado como prop ou inicializado de alguma forma
const projetoId = ref(null); //adicionado

//adicionado
onMounted(() => {
    if (props.aluno && props.aluno.id) {
        projetoId.value = props.aluno.id; // Definindo o ID do projeto igual ao ID do aluno
    } else {
        console.error("Aluno não definido ou ID do aluno não disponível");
    }
    fetchAtividades();
});


// Função para redirecionar para a página do projeto do aluno
const abrirProjeto = () => {
    if (!projetoId.value) {//.value
        console.error("ID do projeto não definido");
        return;
    }
    window.location.href = `/aluno/projeto/${projetoId.value}`;
};



// Função para buscar as atividades do backend
const fetchAtividades = async () => {
    try {
        const response = await axios.get('/atividades');
        atividades.value = response.data;
        console.log('Atividades:', atividades.value);
    } catch (error) {
        console.error('Erro ao buscar atividades:', error);
    }
};

// Função para abrir o modal da atividade
const openAtividadeModal = (atividade) => {
    currentAtividade.value = { ...atividade };
    isAtividadeModalOpen.value = true;
};

// Função para fechar o modal da atividade
const closeAtividadeModal = () => {
    isAtividadeModalOpen.value = false;
    currentAtividade.value = {};
    link.value = '';
};

// Função para submeter o link e marcar a atividade como concluída
const submitLink = async () => {
    try {
        await axios.post(`/atividades/${currentAtividade.value.id}/submeter-link`, { link: link.value });

        const atividadeIndex = atividades.value.findIndex(atividade => atividade.id === currentAtividade.value.id);
        if (atividadeIndex !== -1) {
            atividades.value[atividadeIndex].concluida = true;
        }

        console.log(`Link enviado: ${link.value}`);
        closeAtividadeModal();
    } catch (error) {
        console.error('Erro ao enviar link:', error);
    }
};

// Função para redirecionar para a página do projeto do aluno
const goToProjetos = () => {
    window.location.href = '/projetos';
};

// Função para formatar a data
const formatDate = (date) => {
    const [year, month, day] = date.split('-');
    return `${day}/${month}/${year}`;
};


function redirectToCriarProjeto() {
  Inertia.visit('/aluno/criar-projeto');
}

</script>

<style>
/* Reset de estil   os */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #3c4043;
    margin: 0;
    padding: 0;
}

/* Barra de navegação */
.navbar {
    background-color: #F29400;
    color: #fff;
    height: 100px;
    margin-bottom: 20px;
    padding: 10px;
    display: flex;
    justify-content: center;
}

.navbar-brand {
    font-size: 24px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
}

/* Conteúdo principal */
.container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin: 20px;
}

.sidebar {
    width: 200px;
    background-color: #f8f9fa;
    padding: 20px;
    border-right: 1px solid #ccc;
}

.main-content {
    flex: 1;
    background-color: #fff;
    padding: 20px;
}

/* Estilo para o texto selecionado */
.sidebar-selected {
  color: #F29400; /* Laranja vibrante */
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  display: block;
  padding: 10px 15px;
  cursor: default; /* Indica que não é clicável */
}

/* Remove qualquer aparência de link ou botão */
.sidebar-selected:hover {
  text-decoration: none;
  background-color: transparent; /* Nenhuma cor de fundo no hover */
}


/* Botões destacados na barra lateral */
.sidebar-button {
    display: block;
    background-color: #F29400; /* Laranja vibrante */
    color: rgb(255, 255, 255);
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    padding: 10px 15px;
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.sidebar-button:hover {
    background-color: #ff9e30; /* Laranja mais claro ao passar o mouse */
    transform: scale(1.05); /* Efeito de zoom leve */
    text-decoration: none;
}


/* Links */
.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar a {
    text-decoration: none;
    color: #ffffff;
}

/* Estilos da lista de atividades */
.atividades-list ul {
    list-style-type: none;
    padding: 0;
}

.atividades-list li {
    background-color: #f8f9fa;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}

.atividades-list li.completed {
    background-color: #d4edda;
}

.atividades-list h3 {
    margin-bottom: 5px;
}

.atividades-list p {
    margin-bottom: 5px;
}

.atividades-list p.concluida {
    color: green;
    font-weight: bold;
}

/* Estilos do modal */
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    width: 400px;
    padding: 20px;
    border-radius: 8px;
    background-color: #f4f4f4;
    position: relative;
}

.form-container {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.submit-btn {
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #218838;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}
.logo-container {
    display: flex;
    align-items: center;
    width:300px;
}
.logo-image {
    max-width: 200px;
    height: auto;
}
.aluno-info {
    font-size: 20px;
    font-weight: bold;
    color: #F29400;
    margin-left: 20px;
}

</style>
