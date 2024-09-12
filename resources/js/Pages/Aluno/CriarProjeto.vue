<template>
  <!-- Barra de navegação -->
  <div class="navbar">
    <div class="logo-container">
      <img src="/images/logo.png" alt="Logo do Sistema de Extensão Curricular" class="logo-image" />
    </div>
  </div>

  <div class="container">
    <div class="card shadow p-4">
      <h1 class="text-center mb-4">Criar Novo Projeto</h1>

      <!-- Exibe a mensagem de sucesso, se houver -->
      <div v-if="successMessage" class="alert alert-success text-center">
        {{ successMessage }}
      </div>

      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="titulo">Título do Projeto</label>
          <br>
          <input v-model="form.titulo" id="titulo" type="text" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="descricao">Descrição</label>
          <br>
          <textarea v-model="form.descricao" id="descricao" class="form-control" required></textarea>
        </div>

        <div class="form-group">
          <label for="dataInicio">Data de Início</label>
          <br>
          <input v-model="form.dataInicio" id="dataInicio" type="date" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="dataFim">Data de Conclusão</label>
          <br>
          <input v-model="form.dataFim" id="dataFim" type="date" class="form-control" required>
        </div>

        <!-- Botão de submissão, desabilitado enquanto o formulário é submetido -->
        <button :disabled="isSubmitting" type="submit" class="btn btn-primary w-100 mt-3">
          Criar Projeto
        </button>
      </form>

      <!-- Botão para voltar para a página inicial do aluno -->
      <button @click="goBack" class="btn btn-secondary w-100 mt-3">Voltar para Home</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

// Estado do formulário
const form = ref({
  titulo: '',
  descricao: '',
  dataInicio: '',
  dataFim: '',
});

const successMessage = ref(''); // Variável para armazenar a mensagem de sucesso
const isSubmitting = ref(false); // Estado para controlar a submissão do formulário

// Submissão do formulário
function submitForm() {
  // Desabilita o botão de envio
  isSubmitting.value = true;

  Inertia.post(route('projetos.store'), form.value, {
    onSuccess: () => {
      const { flash } = usePage().props.value;

      if (flash && flash.success) {
        successMessage.value = flash.success; // Define a mensagem de sucesso
      }

      // Limpa o formulário após a criação bem-sucedida
      form.value = {
        titulo: '',
        descricao: '',
        dataInicio: '',
        dataFim: '',
      };

      // Reativa o botão de envio após a submissão bem-sucedida
      isSubmitting.value = false;
    },
    onError: (errors) => {
      console.error(errors); // Exibe os erros no console

      // Reativa o botão caso haja erros
      isSubmitting.value = false;
    }
  });
}

// Função para voltar para a página AlunoHome
function goBack() {
  Inertia.visit('/alunoHome');
}
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  padding: 20px;
}

.card {
  width: 100%;
  max-width: 500px;
  background-color: #f8f9fa;
  border-radius: 10px;
  border: none;
}

.form-group {
  margin-bottom: 20px;
}

.form-control {
  padding: 10px;
  font-size: 16px;
  width: 100%; /* Ajustado para ocupar toda a largura */
}

.btn-primary {
  background-color: #28a745;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  margin-bottom: 20px;
}
.btn-primary:hover {
  background-color: #218838;
}

.btn-secondary {
  background-color: #0d0ab4;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

.btn-secondary:hover {
  background-color: #0d0ab4;
}

.alert {
  margin-bottom: 15px;
  padding: 10px;
  border-radius: 5px;
  color: #fff;
}

.alert-success {
  background-color: #28a745;
}

.mt-3 {
  margin-top: 15px;
}

.text-center {
  text-align: center;
}

.navbar {
  background-color: #F29400;
  color: #fff;
  height: 100px;
  margin-bottom: 20px;
  padding: 10px;
  display: flex;
  justify-content: center;
}

.logo-container {
  display: flex;
  align-items: center;
  width: 300px;
}

.logo-image {
  max-width: 200px;
  height: auto;
}
</style>
