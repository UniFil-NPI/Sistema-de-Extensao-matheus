<template>
    <div>
        <!-- Barra de navegação -->
        <div class="navbar">
            <a href="#" class="navbar-brand">Sistema de Extensão Curricular</a>
        </div>

        <!-- Conteúdo principal -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="sidebar">
                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Turmas</a></li>
                    <li><a href="#" @click="showAtividades = true">Atividades</a></li>
                    <li><a href="#">Perguntas</a></li>
                    <li><a href="#">Notas</a></li>
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
                    <p>{{ currentAtividade.descricao }}</p>
                    <p>Data de Entrega: {{ formatDate(currentAtividade.dataEntrega) }}</p>
                    <form @submit.prevent="submitLink">
                        <label for="link">Link:</label>
                        <input type="url" id="link" v-model="link" required>
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const showAtividades = ref(false);
const atividades = ref([]);
const isAtividadeModalOpen = ref(false);
const currentAtividade = ref({});
const link = ref('');

// Função para buscar as atividades do backend
const fetchAtividades = async () => {
    try {
        const response = await axios.get('/atividades');
        atividades.value = response.data;
        console.log('Atividades:', atividades.value); // Verifique os dados retornados
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
        // Envia o link para o backend (substitua '/atividade/{id}/submeter-link' com a rota correta)
        await axios.post(`/atividades/${currentAtividade.value.id}/submeter-link`, { link: link.value });

        // Marca a atividade como concluída
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

// Função para formatar a data
const formatDate = (date) => {
    const [year, month, day] = date.split('-');
    return `${day}/${month}/${year}`;
};

// Fetch atividades quando o componente é montado
onMounted(fetchAtividades);
</script>

<style>
/* Reset de estilos */
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
    background-color: orange;
    color: #fff;
    height: 100px;
    margin-bottom: 20px;
    padding: 10px;
    display: flex;
    justify-content: flex-start;
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
    color: #3c4043;
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
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}
</style>

