<!-- LoginAluno.vue -->
<template>
    <div class="container">
        <div class="form-container">
            <img src="/images/logo.png" alt="UniFil Logo" class="logo">
            <form @submit.prevent="submit">
                <label for="email">E-mail: <span class="required">*</span></label>
                <input type="email" id="email" v-model="form.email" required>

                <label for="senha">Senha: <span class="required">*</span></label>
                <input type="password" id="senha" v-model="form.password" required>

                <button type="submit">Entrar</button>
            </form>
            <button @click="redirectToForgotPassword" class="forgot-password">Esqueci minha senha</button>
            <input type="checkbox" name="remember"> Lembrar-me
        </div>
    </div>
</template>

<script setup> 
import { useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const form = useForm({
    email: '',
    password: '',
});
/*
const submit = () => {           SER IMPLEMENTADO APÓS COLOCAR SENHA NO BANCO DE DADOS
    form.post(route('loginAluno.post'), {
        onSuccess: () => {
            window.location.href = route('alunoHome');
        },
    });
};
*/

const submit = () => {
    form.post(route('loginAluno.post'));
        window.location.href = route('alunoHome');
};

function redirectToForgotPassword() {
    Inertia.visit('/forgotPasswordAluno'); // Rota para a tela de recuperação de senha do aluno
}
</script>

<style scoped>
/* Estilo semelhante ao LoginProfessor.vue */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 0 20px;
}

.form-container {
    background-color: #f4a100;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    max-width: 100%;
    box-sizing: border-box;
}

.logo {
    display: block;
    margin: 0 auto 20px;
    width: 250px;
    height: auto;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #fff;
}

.required {
    color: red;
}

input {
    margin-bottom: 15px;
    padding: 10px;
    border: none;
    border-radius: 4px;
    width: calc(100% - 20px);
    box-sizing: border-box;
}

button {
    background-color: #333;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #555;
}

.forgot-password {
    margin-top: 10px;
    background-color: transparent;
    color: white;
    border: none;
    cursor: pointer;
}

.forgot-password:hover {
    text-decoration: underline;
}
</style>