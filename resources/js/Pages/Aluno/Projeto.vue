<template>
  <div class="portfolio-container">
    <div class="orange-banner">
      <!-- Campo de edição do título -->
      <input 
        v-model="projeto.titulo" 
        class="edit-title" 
        placeholder="Digite o título do projeto"
      />
      <button @click="salvarTitulo" class="save-btn">Salvar Título</button>
    </div>
    

    <section class="portfolio-section">
      <h2>Descrição do Projeto</h2>
      <!-- Campo de edição da descrição -->
      <textarea 
        v-model="projeto.descricao" 
        class="edit-description" 
        placeholder="Digite a descrição do projeto"
      ></textarea>
      <button @click="salvarDescricao" class="save-btn">Salvar Descrição</button>
    </section>

      
    <section class="portfolio-section">
      <h2>Datas</h2>
      <p><strong>Data de Início:</strong> {{ projeto.dataInicio }}</p>
      <p><strong>Data de Fim:</strong> {{ projeto.dataFim }}</p>
    </section>

    <section class="portfolio-section">
      <h2>Objetivos</h2>
      <ul class="objective-list">
        <li v-for="(objetivo, index) in projeto.objetivos" :key="index">
          {{ objetivo }}
        </li>
      </ul>
      <input v-model="novoObjetivo" placeholder="Adicionar Objetivo" />
      <button @click="adicionarObjetivo">Adicionar</button>
    </section>

    <section class="portfolio-section">
      <h2>Tecnologias Utilizadas</h2>
      <ul class="tech-list">
        <li v-for="(tecnologia, index) in projeto.tecnologias" :key="index">
          {{ tecnologia }}
        </li>
      </ul>
      <input v-model="novaTecnologia" placeholder="Adicionar Tecnologia" />
      <button @click="adicionarTecnologia">Adicionar</button>
    </section>

    <section class="portfolio-section">
      <h2>Cronograma</h2>
      <ul>
        <li v-for="(etapa, index) in projeto.cronograma" :key="index">
          {{ etapa }}
        </li>
      </ul>
      <input v-model="novaEtapa" placeholder="Adicionar Etapa do Cronograma" />
      <button @click="adicionarEtapa">Adicionar</button>
    </section>

    <section class="portfolio-section">
      <h2>Adicionar Informações Avulsas</h2>
      <ul>
        <li v-for="(info, index) in projeto.informacoes_avulsas" :key="index">
          {{ info }}
        </li>
      </ul>
      <br>
      <textarea
        v-model="novaInformacao" 
        placeholder="Escreva alguma informação adicional..."
      ></textarea>
      <br>
      <button @click="adicionarInformacao">Adicionar Informação</button>
    </section>

    <button @click="salvarProjeto" class="save-button">Salvar Projeto</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';


// Configurar o Axios para enviar o token CSRF
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Recebendo o projeto via props
const props = defineProps(['projeto']);
const projeto = ref({ 
  titulo: '', 
  descricao: '', 
  dataInicio: '', 
  dataFim: '', 
  objetivos: [], 
  tecnologias: [], 
  cronograma: [], 
  informacoes_avulsas: [] 
});

// Copiar os dados do props para projeto após a montagem do componente
onMounted(() => {
  Object.assign(projeto.value, props.projeto);
  projeto.value.titulo = props.projeto.titulo || '';
  projeto.value.descricao = props.projeto.descricao || '';
  projeto.value.dataInicio = props.projeto.dataInicio || '';
  projeto.value.dataFim = props.projeto.dataFim || '';
  projeto.value.objetivos = JSON.parse(props.projeto.objetivos || '[]'); // Parse JSON
  projeto.value.tecnologias = JSON.parse(props.projeto.tecnologias || '[]'); // Parse JSON
  projeto.value.cronograma = JSON.parse(props.projeto.cronograma || '[]'); // Parse JSON
  projeto.value.informacoes_avulsas = JSON.parse(props.projeto.informacoes_avulsas || '[]'); // Parse JSON
});

// Variáveis temporárias para entrada de dados
const novoObjetivo = ref('');
const novaTecnologia = ref('');
const novaEtapa = ref('');
const novaInformacao = ref('');

// Funções para adicionar elementos nas listas
const adicionarObjetivo = () => {
  if (novoObjetivo.value.trim() !== '') {
    projeto.value.objetivos.push(novoObjetivo.value);
    novoObjetivo.value = '';
  }
};

const adicionarTecnologia = () => {
  if (novaTecnologia.value.trim() !== '') {
    projeto.value.tecnologias.push(novaTecnologia.value);
    novaTecnologia.value = '';
  }
};

const adicionarEtapa = () => {
  if (novaEtapa.value.trim() !== '') {
    projeto.value.cronograma.push(novaEtapa.value);
    novaEtapa.value = '';
  }
};

const adicionarInformacao = () => {
  if (novaInformacao.value.trim() !== '') {
    projeto.value.informacoes_avulsas.push(novaInformacao.value);
    novaInformacao.value = '';
  }
};

// Função para salvar o projeto via API
const salvarProjeto = async () => {
  try {
    const projetoData = { 
      titulo: projeto.value.titulo,
      descricao: projeto.value.descricao,
      objetivos: projeto.value.objetivos,
      tecnologias: projeto.value.tecnologias,
      cronograma: projeto.value.cronograma,
      informacoes_avulsas: projeto.value.informacoes_avulsas,
    };

    await axios.put(`/aluno/projeto/${projeto.value.id}`, projetoData); // Corrigido
    alert('Projeto salvo com sucesso!');
  } catch (error) {
    console.error('Erro ao salvar projeto:', error);
    console.log(error.response.data);
    alert('Erro ao salvar projeto.');
  }
};

const salvarTitulo = async () => {
  try {
    await axios.put(`/aluno/projeto/${projeto.value.id}`, { titulo: projeto.value.titulo });
    alert('Título salvo com sucesso!');
  } catch (error) {
    console.error('Erro ao salvar título:', error);
    alert('Erro ao salvar título.');
  }
};

const salvarDescricao = async () => {
  try {
    await axios.put(`/aluno/projeto/${projeto.value.id}`, { descricao: projeto.value.descricao });
    alert('Descrição salva com sucesso!');
  } catch (error) {
    console.error('Erro ao salvar descrição:', error);
    alert('Erro ao salvar descrição.');
  }
};

</script>
<style scoped>
/* Estilo geral da página */
.portfolio-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
  color: #333;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Banner Laranja */
.orange-banner {
  background-color: #F29400;
  color: white;
  padding: 15px;
  text-align: center;
  border-radius: 8px;
  margin-bottom: 20px;
}

.orange-banner h1 {
  font-size: 24px;
  margin: 0;
}

/* Seções */
.portfolio-section {
  margin-bottom: 20px;
}

.portfolio-section h2 {
  font-size: 20px;
  color: #555;
  border-bottom: 2px solid #ddd;
  padding-bottom: 8px;
  margin-bottom: 10px;
}

/* Listas e Inputs */
.objective-list,
.tech-list,
.portfolio-section ul {
  list-style-type: disc;
  padding-left: 20px;
}

.portfolio-section p,
.portfolio-section li {
  font-size: 16px;
  line-height: 1.5;
}

input[type="text"],
textarea {
  width: 100%;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 10px;
  margin-bottom: 10px;
}


/* Botões */
button {
  background-color: #F29400;
  color: white;
  border: none;
  padding: 8px 12px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-top: 8px;
}

button:hover {
  background-color: #F29400;
}

/* Botão de salvar */
.save-button {
  width: 100%;
  background-color: #4caf50;
  padding: 10px;
  font-size: 18px;
  margin-top: 20px;
}

.save-button:hover {
  background-color: #43a047;
}

/* Responsividade */
@media (max-width: 600px) {
  .portfolio-container {
    padding: 15px;
  }

  .orange-banner h1 {
    font-size: 20px;
  }

  .portfolio-section h2 {
    font-size: 18px;
  }

  button,
  .save-button {
    font-size: 16px;
  }
}

.save-btn {
  margin-top: 10px;
  padding: 8px 12px;
  background-color: #F29400;
  color: #ffffff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
}

.save-btn:hover {
  background-color: #F29400;
}


.edit-title {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
}

.edit-description {
  font-size: 16px;
  color: #333;
  width: 100%;
  height: 100px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
  margin-top: 5px;
}




</style>

