<template>
  <div class="portfolio-container">
    <!-- Faixa laranja no topo -->
    <div class="orange-banner">
      <h1>{{ projeto.titulo }}</h1>
    </div>

    <!-- Seção de descrição do projeto -->
    <section class="portfolio-section">
      <h2>Descrição do Projeto</h2>
      <p>{{ projeto.descricao }}</p>
    </section>

    <!-- Seção de objetivos -->
    <section class="portfolio-section">
      <h2>Objetivos</h2>
      <ul class="objective-list">
        <li v-for="(objetivo, index) in projeto.objetivos" :key="index">
          {{ objetivo }}
        </li>
      </ul>
    </section>

    <!-- Seção de tecnologias utilizadas -->
    <section class="portfolio-section">
      <h2>Tecnologias Utilizadas</h2>
      <ul class="tech-list">
        <li v-for="(tecnologia, index) in projeto.tecnologias" :key="index">
          {{ tecnologia }}
        </li>
      </ul>
    </section>

    <!-- Seção de cronograma -->
    <section class="portfolio-section">
      <h2>Cronograma</h2>
      <p>{{ projeto.cronograma }}</p>
    </section>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

// Dados fictícios para demonstração, substitua conforme necessário
const projeto = reactive({
  titulo: 'Nome do Projeto',
  descricao: 'Uma breve descrição do projeto.',
  objetivos: ['Objetivo 1', 'Objetivo 2', 'Objetivo 3'],
  tecnologias: ['Vue.js', 'Laravel', 'MySQL'],
  cronograma: 'Data de início: 01/08/2024 - Data de conclusão: 30/11/2024'
})
</script>

<style scoped>
.portfolio-container {
  padding: 40px;
  max-width: 1000px;
  margin: 0 auto;
  background-color: #fff;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

.orange-banner {
  background-color: #F29400;
  color: white;
  padding: 20px;
  text-align: center;
  width: 100%;
  border-radius: 10px 10px 0 0;
}

.portfolio-section {
  margin: 30px 0;
  text-align: left;
}

.portfolio-section h2 {
  font-size: 1.8em;
  color: #333;
  margin-bottom: 15px;
  border-bottom: 2px solid #F29400;
  padding-bottom: 5px;
}

.portfolio-section p,
.portfolio-section ul {
  font-size: 1.2em;
  line-height: 1.6;
  color: #555;
}

.portfolio-section ul {
  list-style-type: disc;
  margin-left: 40px;
  padding-left: 0;
}

.objective-list li {
  margin-bottom: 10px;
}

.tech-list li {
  display: inline-block;
  background-color: #f0f0f0;
  padding: 8px 12px;
  border-radius: 5px;
  margin-right: 10px;
  margin-bottom: 10px;
  font-weight: bold;
  color: #333;
}

@media (max-width: 768px) {
  .portfolio-container {
    padding: 20px;
  }

  .portfolio-section h2 {
    font-size: 1.5em;
  }

  .portfolio-section p,
  .portfolio-section ul {
    font-size: 1.1em;
  }
}
</style>