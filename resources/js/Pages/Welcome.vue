<template>
    <div class="container">
        <div class="orange-bg">
            <h1>Bem-vindo ao Sistema de Extensão Curricular</h1>
            <button @click="redirectToLogin">Entrar como Professor</button>
            <button @click="redirectToRegister">Entrar como Aluno</button>
        </div>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';

const page = usePage()

function redirectToLogin() {
    Inertia.visit('/loginProfessor'); // Rota para a tela de login do professor
}

function redirectToRegister() {
    Inertia.visit('/registerAluno'); // Rota para a tela de registro do aluno
}
</script>

<script>

export default {
    methods: {
        goToCadastroAluno() {
            Inertia.visit('/cadastro-aluno');
        },
        goToLoginProfessor() {
            Inertia.visit('/login-professor');
        }
    }
};
</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.orange-bg {
    background-color: orange;
    padding: 50px;
    text-align: center;
    border-radius: 8px;
}
button {
    display: block;
    width: 200px;
    padding: 15px;
    margin: 20px auto;
    background-color: white;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background-color: lightgray;
}
h1 {
    color: white;
    margin-bottom: 40px;
}
</style>
