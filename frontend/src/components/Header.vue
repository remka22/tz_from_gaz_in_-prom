<template>
    <header class="header">
      <h1>Методы</h1>
      <div class="buttons">
        <button @click="goToCategories">Категории</button>
        <button @click="goToFullList">Полный список</button>
        <button @click="goToReports">Отчеты покупок</button>
      </div>
    </header>
  </template>
  
  <script lang="ts" setup>
  import { useRouter } from 'vue-router';
  
  const router = useRouter();
  
  const goToCategories = () => {
    router.push('/categories');
  };
  
  const goToFullList = () => {
    router.push('/full-list');
  };
  
  const goToReports = () => {
    router.push('/reports');
  };
  </script>
  
  <style scoped>
  .header {
    /* padding: 20px; */
    background-color: #f5f5f5;
    text-align: center;
  }
  
  .buttons {
    margin-top: 10px;
  }
  
  button {
    margin: 0 10px;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  </style>