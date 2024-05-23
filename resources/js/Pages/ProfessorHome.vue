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
                    <li><a href="#">Atividades</a></li>
                    <li><a href="#">Perguntas</a></li>
                    <li><a href="#">Notas</a></li>
                    <li><a href="#" @click="showAlunos = true">Alunos</a></li> <!-- Adicionada a aba Alunos -->
                </ul>
            </div>

            <!-- Conteúdo principal -->
            <div class="main-content">
                <h1>Bem-vindo ao Sistema de Extensão Curricular</h1>
                <br>

                <!-- Formulário de pesquisa -->
                <div class="search-form">
                    <h2>Pesquisar Aluno</h2>
                    <form @submit.prevent="searchStudent">
                        <input type="text" v-model="search" class="search-input" placeholder="Digite o nome do aluno">
                        <button type="submit" class="search-button">Pesquisar</button>
                    </form>
                </div>

                <!-- Lista de alunos -->
                <div v-if="showAlunos" class="alunos-list">
                    <h2>Lista de Alunos</h2>
                    <table class="alunos-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Tipo de Extensão</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="aluno in filteredAlunos" :key="aluno.id">
                                <td>{{ aluno.nome }}</td>
                                <td>{{ aluno.email }}</td>
                                <td>{{ aluno.telefone }}</td>
                                <td>{{ aluno.tipoExtensao }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const search = ref('');
const showAlunos = ref(false);
const alunos = ref([]);

const searchStudent = () => {
    // Lógica de pesquisa de aluno
    console.log(`Pesquisando aluno: ${search.value}`);
};

// Computed property para filtrar alunos com base na pesquisa
const filteredAlunos = computed(() => {
    if (!search.value) {
        return alunos.value;
    }
    return alunos.value.filter(aluno => 
        aluno.nome.toLowerCase().includes(search.value.toLowerCase())
    );
});

const fetchAlunos = async () => {
    try {
        const response = await axios.get('/alunos');
        alunos.value = response.data;
        console.log(alunos.value); // Log para depuração
    } catch (error) {
        console.error('Erro ao buscar alunos:', error);
    }
};

onMounted(fetchAlunos);
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

/* Formulário de pesquisa */
.search-form {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    padding: 10px;
}

.search-input {
    width: 150px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-button {
    padding: 8px 20px;
    background-color: #4285f4;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Estilos da tabela */
.alunos-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.alunos-table th, .alunos-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}

.alunos-table th {
    background-color: #f2f2f2;
}
</style>
