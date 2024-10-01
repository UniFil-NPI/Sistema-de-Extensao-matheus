<template>
    <div class="container">
        <div class="orange-bg">
            <h1>Bem-vindo ao UniExtension</h1>
            <button @click="redirectToLogin">Entrar como Professor</button>
            <button @click="redirectToAlunoEntry">Entrar como Aluno</button>
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
function redirectToAlunoEntry() {
    Inertia.visit('/alunoEntry'); 
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
    background-color: orange;
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