<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import axios from '../axios';
import CategoryList from '@/components/CategoryList.vue';

const categories = ref<any[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const fetchCategories = async () => {
  try {
    const response = await axios.get('/categories_full_list');
    categories.value = response.data;
  } catch (err) {
    error.value = 'Ошибка загрузки данных';
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchCategories();
});
</script>

<template>
  <div class="full-list">
    <h2 class="title">Полный список</h2>
    <div v-if="loading" class="loading">Загрузка...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else>
      <CategoryList v-for="category in categories" :key="category.id" :category="category" />
    </div>
  </div>
</template>

<style scoped>
.full-list {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.title {
  text-align: center;
  color: #333;
}

.loading {
  text-align: center;
  color: #007bff;
}

.error {
  text-align: center;
  color: red;
  font-weight: bold;
}
</style>