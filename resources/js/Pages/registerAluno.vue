<template>
    <div class="container">
        <div class="form-container">
            <img src="/images/logo.png" alt="UniFil Logo" class="logo">
            <form @submit.prevent="submit">
                <label for="nome">Nome: <span class="required">*</span></label>
                <input type="text" id="nome" v-model="form.nome" required>

                <label for="email">E-mail: <span class="required">*</span></label>
                <input type="email" id="email" v-model="form.email" required>

                <label for="telefone">Telefone / Whatsapp: <span class="required">*</span></label>
                <div class="telefone-container">
                    <input type="text" id="ddd" v-model="form.ddd" placeholder="DDD" required>
                    <input type="text" id="telefone" v-model="form.telefone" placeholder="Telefone" required>
                </div>

                <label for="tipo-extensao">Tipo de Extensão: <span class="required">*</span></label>
                <select id="tipo-extensao" v-model="form.tipoExtensao" required>
                    <option value="aplicativo">Aplicativo</option>
                    <option value="pensamento-computacional">Pensamento Computacional</option>
                </select>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';


const form = useForm({
    nome: '',
    email: '',
    ddd: '',
    telefone: '',
    tipoExtensao: '',
});

//const submit = () => {
    //form.post(route('RegisterAluno.store')) };;

    const message = ref('');

const submit = async () => {
    try {
        const response = await form.post(route('RegisterAluno.store'), {
            onFinish: () => {
                if (!form.hasErrors()) {
                    message.value = 'Aluno registrado com sucesso!';
                    form.reset();
                }
            },
        });

        if (response.data.message) {
            message.value = response.data.message;
        }
    } catch (error) {
        console.error('Erro ao enviar o formulário:', error);
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
    padding: 40px; /* Aumentado para maior espaçamento */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px; /* Aumentado para maior largura */
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
    width: calc(100% - 20px); /* Ajuste para considerar o padding */
}

.telefone-container {
    display: flex;
    gap: 10px;
}

.telefone-container input {
    width: calc(50% - 10px); /* Ajustado para gap de 10px */
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
