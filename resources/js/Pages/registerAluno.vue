<template>
    <div class="container">
        <div class="form-container">
            <img src="/images/logo.png" alt="UniFil Logo" class="logo">
            <form @submit.prevent="submit">
                <label for="nome">Nome: <span class="required">*</span></label>
                <input type="text" id="nome" v-model="form.nome" required>

                <label for="email">E-mail: <span class="required">*</span></label>
                <input type="email" id="email" v-model="form.email" required>

                <label for="password">Senha: <span class="required">*</span></label>
                <input type="password" id="password" v-model="form.password" required>

                <label for="password_confirmation">Confirmar Senha: <span class="required">*</span></label>
                <input type="password" id="password_confirmation" v-model="form.password_confirmation" required>



                <label for="fase-extensao">Fase da Extensão: <span class="required">*</span></label>
                <select id="fase-extensao" v-model="form.faseExtensao" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>

                <label for="nome-projeto">Nome do Projeto: <span class="required">*</span></label>
                <input type="text" id="nome-projeto" v-model="form.nomeProjeto" required>

                <button type="submit">Enviar</button>
                <p v-if="message">{{ message }}</p>

            </form>
            
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const form = useForm({
    nome: '',
    email: '',
    password: '',
    password_confirmation: '',
    faseExtensao: '',
    nomeProjeto: '',// Alterado aqui
    
});

const message = ref('');

const submit = async () => {
    try {
        await form.post(route('registerAluno.store'), { // Utilize a nova rota aqui
            onFinish: () => {
                if (Object.keys(form.errors).length === 0) { // Verifica se não há erros
                    message.value = 'Aluno registrado com sucesso!';
                    form.reset();
                }
            },
           
            onError: () => {
                message.value = 'Erro ao registrar aluno. Verifique os dados e tente novamente.';
            }
        });
    } catch (error) {
        console.error('Erro ao enviar o formulário:', error);
        message.value = 'Ocorreu um erro inesperado ao enviar o formulário.';
    }
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
}

.form-container {
    background-color: #f4a100;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
}

.logo {
    display: block;
    margin: 0 auto 20px;
    width: 150px;
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

input, select {
    margin-bottom: 15px;
    padding: 10px;
    border: none;
    border-radius: 4px;
    width: calc(100% - 20px);
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