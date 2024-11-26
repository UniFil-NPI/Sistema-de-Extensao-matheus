<template>
  <div class="portfolio-container">
    <div class="orange-banner">
      <input 
        v-model="projeto.titulo" 
        class="edit-title" 
        placeholder="Digite o título do projeto"
      />
      <button @click="salvarTitulo" class="save-btn">Salvar Título</button>
    </div>

    <section class="portfolio-section">
      <h2>Descrição do Projeto</h2>
      <textarea 
        v-model="projeto.descricao" 
        class="edit-description" 
        placeholder="Digite a descrição do projeto"
      ></textarea>
      <button @click="salvarDescricao" class="save-btn">Salvar Descrição</button>
    </section>

    <section class="portfolio-section">
      <h2>Objetivos</h2>
      <ul class="objective-list">
        <li v-for="(objetivo, index) in projeto.objetivos" :key="index">
          <div v-if="checklist.objetivos[index]">
            <!-- Campo de edição do objetivo -->
            <input 
              v-model="editarObjetivo[index]" 
              placeholder="Editar Objetivo"
            />
            <button @click="salvarObjetivo(index)">Salvar</button>
            <button @click="removerObjetivo(index)">Excluir</button>
          </div>
          <div v-else>
            {{ objetivo }}
            <input 
              type="checkbox" 
              v-model="checklist.objetivos[index]" 
              @change="handleCheckboxChange('objetivos', index)" 
            />
          </div>
        </li>
      </ul>
      <input v-model="novoObjetivo" placeholder="Adicionar Objetivo" />
      <button @click="adicionarObjetivo">Adicionar</button>
    </section>

    <section class="portfolio-section">
      <h2>Tecnologias Utilizadas</h2>
      <ul class="tech-list">
        <li v-for="(tecnologia, index) in projeto.tecnologias" :key="index">
          <div v-if="checklist.tecnologias[index]">
            <!-- Campo de edição da tecnologia -->
            <input 
              v-model="editarTecnologia[index]" 
              placeholder="Editar Tecnologia"
            />
            <button @click="salvarTecnologia(index)">Salvar</button>
            <button @click="removerTecnologia(index)">Excluir</button>
          </div>
          <div v-else>
            {{ tecnologia }}
            <input 
              type="checkbox" 
              v-model="checklist.tecnologias[index]" 
              @change="handleCheckboxChange('tecnologias', index)" 
            />
          </div>
        </li>
      </ul>
      <input v-model="novaTecnologia" placeholder="Adicionar Tecnologia" />
      <button @click="adicionarTecnologia">Adicionar</button>
    </section>

    <section class="portfolio-section">
      <h2>Cronograma</h2>
      <ul>
        <li v-for="(etapa, index) in projeto.cronograma" :key="index">
          <div v-if="checklist.cronograma[index]">
            <!-- Campo de edição da etapa -->
            <input 
              v-model="editarEtapa[index]" 
              placeholder="Editar Etapa"
            />
            <button @click="salvarEtapa(index)">Salvar</button>
            <button @click="removerEtapa(index)">Excluir</button>
          </div>
          <div v-else>
            {{ etapa }}
            <input 
              type="checkbox" 
              v-model="checklist.cronograma[index]" 
              @change="handleCheckboxChange('cronograma', index)" 
            />
          </div>
        </li>
      </ul>
      <input v-model="novaEtapa" placeholder="Adicionar Etapa do Cronograma" />
      <button @click="adicionarEtapa">Adicionar</button>
    </section>

    <section class="portfolio-section">
      <h2>Informações Avulsas</h2>
      <ul>
        <li v-for="(info, index) in projeto.informacoes_avulsas" :key="index">
          <div v-if="checklist.informacoes_avulsas[index]">
            <!-- Campo de edição da informação avulsa -->
            <textarea 
              v-model="editarInformacao[index]" 
              placeholder="Editar Informação Avulsa"
            ></textarea>
            <button @click="salvarInformacao(index)">Salvar</button>
            <button @click="removerInformacao(index)">Excluir</button>
          </div>
          <div v-else>
            {{ info }}
            <input 
              type="checkbox" 
              v-model="checklist.informacoes_avulsas[index]" 
              @change="handleCheckboxChange('informacoes_avulsas', index)" 
            />
          </div>
        </li>
      </ul>
      <textarea v-model="novaInformacao" placeholder="Adicionar Informação Adicional..."></textarea>
      <button @click="adicionarInformacao">Adicionar</button>
    </section>

    <button @click="salvarProjeto" class="save-button">Salvar Projeto</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

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

const checklist = ref({
  objetivos: [],
  tecnologias: [],
  cronograma: [],
  informacoes_avulsas: []
});

// Variáveis temporárias para edição
const editarObjetivo = ref([]);
const editarTecnologia = ref([]);
const editarEtapa = ref([]);
const editarInformacao = ref([]);

// Variáveis temporárias para adicionar itens
const novoObjetivo = ref('');
const novaTecnologia = ref('');
const novaEtapa = ref('');
const novaInformacao = ref('');

onMounted(() => {
  Object.assign(projeto.value, props.projeto);
  projeto.value.titulo = props.projeto.titulo || '';
  projeto.value.descricao = props.projeto.descricao || '';
  projeto.value.dataInicio = props.projeto.dataInicio || '';
  projeto.value.dataFim = props.projeto.dataFim || '';
  projeto.value.objetivos = JSON.parse(props.projeto.objetivos || '[]');
  projeto.value.tecnologias = JSON.parse(props.projeto.tecnologias || '[]');
  projeto.value.cronograma = JSON.parse(props.projeto.cronograma || '[]');
  projeto.value.informacoes_avulsas = JSON.parse(props.projeto.informacoes_avulsas || '[]');
  
  // Inicializar checklist com valores falsos
  checklist.value.objetivos = Array(projeto.value.objetivos.length).fill(false);
  checklist.value.tecnologias = Array(projeto.value.tecnologias.length).fill(false);
  checklist.value.cronograma = Array(projeto.value.cronograma.length).fill(false);
  checklist.value.informacoes_avulsas = Array(projeto.value.informacoes_avulsas.length).fill(false);
});

const handleCheckboxChange = (type, index) => {
  if (checklist.value[type][index]) {
    // Ativar edição
    if (type === 'objetivos') {
      editarObjetivo.value[index] = projeto.value.objetivos[index];
    }
    if (type === 'tecnologias') {
      editarTecnologia.value[index] = projeto.value.tecnologias[index];
    }
    if (type === 'cronograma') {
      editarEtapa.value[index] = projeto.value.cronograma[index];
    }
    if (type === 'informacoes_avulsas') {
      editarInformacao.value[index] = projeto.value.informacoes_avulsas[index];
    }
  }
};

const adicionarObjetivo = () => {
  if (novoObjetivo.value.trim() !== '') {
    projeto.value.objetivos.push(novoObjetivo.value);
    checklist.value.objetivos.push(false); // Adiciona checkbox
    novoObjetivo.value = '';
  }
};

const adicionarTecnologia = () => {
  if (novaTecnologia.value.trim() !== '') {
    projeto.value.tecnologias.push(novaTecnologia.value);
    checklist.value.tecnologias.push(false); // Adiciona checkbox
    novaTecnologia.value = '';
  }
};

const adicionarEtapa = () => {
  if (novaEtapa.value.trim() !== '') {
    projeto.value.cronograma.push(novaEtapa.value);
    checklist.value.cronograma.push(false); // Adiciona checkbox
    novaEtapa.value = '';
  }
};

const adicionarInformacao = () => {
  if (novaInformacao.value.trim() !== '') {
    projeto.value.informacoes_avulsas.push(novaInformacao.value);
    checklist.value.informacoes_avulsas.push(false); // Adiciona checkbox
    novaInformacao.value = '';
  }
};

const salvarTitulo = () => {
  axios.put(`/projetos/${projeto.value.id}`, {
    titulo: projeto.value.titulo,
  });
};

const salvarDescricao = () => {
  axios.put(`/projetos/${projeto.value.id}`, {
    descricao: projeto.value.descricao,
  });
};

const salvarObjetivo = (index) => {
  projeto.value.objetivos[index] = editarObjetivo.value[index];
  checklist.value.objetivos[index] = false;
};

const salvarTecnologia = (index) => {
  projeto.value.tecnologias[index] = editarTecnologia.value[index];
  checklist.value.tecnologias[index] = false;
};

const salvarEtapa = (index) => {
  projeto.value.cronograma[index] = editarEtapa.value[index];
  checklist.value.cronograma[index] = false;
};

const salvarInformacao = (index) => {
  projeto.value.informacoes_avulsas[index] = editarInformacao.value[index];
  checklist.value.informacoes_avulsas[index] = false;
};

const removerObjetivo = (index) => {
  projeto.value.objetivos.splice(index, 1);
  checklist.value.objetivos.splice(index, 1);
};

const removerTecnologia = (index) => {
  projeto.value.tecnologias.splice(index, 1);
  checklist.value.tecnologias.splice(index, 1);
};

const removerEtapa = (index) => {
  projeto.value.cronograma.splice(index, 1);
  checklist.value.cronograma.splice(index, 1);
};

const removerInformacao = (index) => {
  projeto.value.informacoes_avulsas.splice(index, 1);
  checklist.value.informacoes_avulsas.splice(index, 1);
};

const salvarProjeto = () => {
  if (!projeto.value.id) {
    console.error("ID do projeto não encontrado.");
    return;
  }

  axios.put(`/aluno/projeto/${projeto.value.id}`, projeto.value)
    .then(response => {
      console.log("Projeto atualizado com sucesso", response);
    })
    .catch(error => {
      console.error("Erro ao salvar o projeto:", error);
    });
};
</script>


<style scoped>
.info-item {
  display: flex;
  align-items: center;
  margin: 10px 0;
}

.edit-container {
  margin-top: 20px;
}

button {
  margin-top: 10px;
}

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

