<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
import Header from '@/components/Header.vue';
</script>

<template>
  <div id="app">
    <Header />
    <div class="main-content">
      <RouterView />
    </div>
  </div>
</template>


<style scoped>
#app {
  display: flex;
  flex-direction: column;  
  height: 100vh;           
  margin: 0;               
}

.main-content {
  flex: 1;                 
  background-color: #f4f4f4; 
}
</style>