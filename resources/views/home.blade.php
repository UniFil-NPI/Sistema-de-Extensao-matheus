@extends('master')

@section('content')

<div class="orange-bg">
  <h1 class="title">BEM-VINDO AO SISTEMA DE EXTENSÃO CURRICULAR</h1>
  <div class="button-container">
    <button class="button" @click="selectRole('aluno')">Entrar como Aluno</button>
    <button class="button" @click="selectRole('professor')">Entrar como Professor</button>
  </div>
</div>

<script>
export default {
  methods: {
    selectRole(role) {
      // Redirecionar para a tela de cadastro se for aluno
      if (role === 'aluno') {
        // Redirecionar para a página de cadastro de aluno
        window.location.href = '{{ route('CadastroAluno') }}';
      } else if (role === 'professor') {
        // Implementar o redirecionamento para a tela de login do professor
      }
    }
  }
};
</script>

<style scoped>

.orange-bg {
  background-color: orange;
  padding: 20px;
  text-align: center;
  height: 100vh; /* Define a altura da div orange-bg como 100% da altura da tela */
  display: flex;
  flex-direction: column;
  justify-content: space-around; /* Coloca espaço uniforme entre os elementos */
}

.title {
  color: white;
}

.button-container {
  display: flex;
  flex-direction: column;
  align-items: center; /* Centraliza os botões horizontalmente */
  justify-content: center; /* Centraliza os botões verticalmente */
  margin-bottom: 300px; /* Margem inferior negativa para deslocar os botões para cima */
}

.button {
  padding: 20px 50px;
  margin-bottom: 20px;
  border: none;
  border-radius: 10px;
  background-color: white;
  color: black;
  font-size: 18px;
  cursor: pointer;
  width: 300px;
  text-align: center;
  transition: background-color 0.3s ease;
}

.button:hover {
  background-color: rgba(0, 0, 0, 0.1);
}

</style>

<App />
