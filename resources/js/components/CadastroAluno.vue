<template>
  <div class="container">
    <div class="form-container">
      <h2>Cadastro de Aluno</h2>
      <form @submit.prevent="cadastrarAluno">
        <div class="form-group">
          <label for="nome">Nome:</label>
          <input type="text" id="nome" v-model="aluno.nome" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="aluno.email" required>
        </div>
        <div class="form-group">
          <label for="senha">Senha:</label>
          <input type="password" id="senha" v-model="aluno.senha" required>
        </div>
        <div class="form-group">
          <label for="curso">Curso:</label>
          <input type="text" id="curso" v-model="aluno.curso" required>
        </div>
        <div class="form-group">
          <label for="projeto">Projeto:</label>
          <input type="text" id="projeto" v-model="aluno.projeto" required>
        </div>
        <button type="submit">Cadastrar</button>
      </form>
      <div v-if="cadastrado" class="success-message">
        <p>Aluno cadastrado com sucesso!</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      aluno: {
        nome: '',
        email: '',
        senha: '',
        curso: '',
        projeto: ''
      },
      cadastrado: false
    };
  },
  methods: {
    cadastrarAluno() {
      // Aqui você pode enviar os dados do aluno para o backend para o cadastro
      // Após o sucesso do cadastro, defina o flag "cadastrado" como true
      this.cadastrado = true;
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

.form-container {
  width: 400px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  background-color: orange;
  color: white;
  cursor: pointer;
}

button:hover {
  background-color: #ff7b00;
}

.success-message {
  margin-top: 15px;
  padding: 10px;
  border: 1px solid #4caf50;
  border-radius: 5px;
  background-color: #e7f6e7;
  color: #4caf50;
}
</style>

    <CadastroAluno />

