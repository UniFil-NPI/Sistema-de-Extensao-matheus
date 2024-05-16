<template>
  <div>
    <div class="orange-bg">
      <h1>Bem-vindo ao Sistema de Extensão Curricular</h1>
      <button @click="selectRole('aluno')">Entrar como Aluno</button>
      <button @click="selectRole('professor')">Entrar como Professor</button>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    selectRole(role) {
      if (role === 'aluno') {
        this.$router.push({ name: 'CadastroAluno' });
      } else if (role === 'professor') {
        this.$router.push({ name: 'login-professor' });
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
}
</style>
