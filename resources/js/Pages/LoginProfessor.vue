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
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    senha: '',
});

const submit = () => {
    form.post(route('loginProfessor.post'));
};
</script>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

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
    height:auto
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
</style>
