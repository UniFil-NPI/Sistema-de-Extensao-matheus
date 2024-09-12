<!-- AlunoEntry.vue -->
<template>
    <div class="container">
        <div class="orange-bg">
            <h1>Entrar como Aluno</h1>
            <button @click="redirectToRegister">Cadastrar-se</button>
            <button @click="redirectToLogin">Fazer Login</button>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';

function redirectToRegister() {
    Inertia.visit('/registerAluno'); // Rota para a tela de registro do aluno
}

function redirectToLogin() {
    Inertia.visit('/loginAluno'); // Rota para a tela de login do aluno
}
</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.orange-bg {
    background-color: #F29400;
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