<template>
    <div class="projeto-aluno">
      <h2>{{ projeto.titulo }}</h2>
      <p>{{ projeto.descricao }}</p>
      <p><strong>Data de Início:</strong> {{ formatarData(projeto.data_inicio) }}</p>
      <p><strong>Data de Conclusão:</strong> {{ formatarData(projeto.data_conclusao) }}</p>
  
      <h3>Documentos</h3>
      <ul>
        <li v-for="documento in projeto.documentos" :key="documento.id">
          <a :href="documento.caminho" target="_blank">{{ documento.nome }}</a>
        </li>
      </ul>
  
      <h3>Submeter Progresso</h3>
      <form @submit.prevent="submeterProgresso">
        <div class="form-group">
          <label for="descricao">Descrição do Progresso</label>
          <textarea v-model="descricaoProgresso" id="descricao" class="form-control"></textarea>
        </div>
  
        <div class="form-group">
          <label for="arquivo">Selecione o Arquivo</label>
          <input type="file" id="arquivo" @change="onFileChange" class="form-control">
        </div>
  
        <button type="submit" class="btn btn-primary">Enviar Progresso</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        projeto: {
          titulo: 'Título do Projeto',
          descricao: 'Descrição detalhada do projeto.',
          data_inicio: '2024-08-01',
          data_conclusao: '2024-12-01',
          documentos: [
            { id: 1, nome: 'Relatório Inicial', caminho: '/path/to/relatorio_inicial.pdf' },
            { id: 2, nome: 'Código Fonte', caminho: '/path/to/codigo_fonte.zip' },
          ],
        },
        descricaoProgresso: '',
        arquivoProgresso: null,
      };
    },
    methods: {
      formatarData(data) {
        const partes = data.split('-');
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
      },
      onFileChange(event) {
        this.arquivoProgresso = event.target.files[0];
      },
      submeterProgresso() {
        // Aqui você enviaria o progresso para o backend
        console.log('Progresso submetido:', this.descricaoProgresso, this.arquivoProgresso);
      },
    },
  };
  </script>
  
  <style scoped>
  .projeto-aluno {
    margin: 20px;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }
  </style>
  