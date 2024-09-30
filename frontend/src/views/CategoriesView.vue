<script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import axios from '../axios';
  
  const categories = ref<Array<{ id: number, name: string }>>([]);
  const products = ref<Array<{ id: number, name: string, price: number }>>([]);
  const breadcrumbs = ref<Array<{ id: number, name: string }>>([]);
  const currentCategoryId = ref<number | null>(null);
  const parentCategoryId = ref<number | null>(null); // ID родительской категории
  const sortOrder = ref<string>('alpha_asc'); // Начальный порядок сортировки
  
  // Функция для получения категории
  const fetchCategory = async (id: number | null = null) => {
    try {
      const response = await axios.get(`/categories`, {
        params: {
          id: id,
          sort: sortOrder.value
        }
      });
      currentCategoryId.value = id;
      categories.value = response.data.categories;
      products.value = response.data.products || [];
      breadcrumbs.value = response.data.breadcrumbs || [];
      parentCategoryId.value = response.data.parent_category_id;
    } catch (error) {
      console.error('Ошибка при загрузке категории:', error);
    }
  };
  
  // Функция для возврата на уровень выше
  const goBack = () => {
    if (breadcrumbs.value.length > 1) {
      // Возвращаемся на предыдущую категорию
      const previousCategoryId = breadcrumbs.value[breadcrumbs.value.length - 2].id;
      fetchCategory(previousCategoryId);
    } else {
      // Если мы на верхнем уровне, загружаем верхние категории
      fetchCategory(null);
    }
  };
  
  // Загрузка верхнего уровня категорий при монтировании компонента
  onMounted(() => {
    fetchCategory(null);
  });
  </script>

<template>
    <div class="catalog">
      <div class="breadcrumbs">
        <span v-for="(breadcrumb, index) in breadcrumbs" :key="index">
          <button @click="fetchCategory(breadcrumb.id)">{{ breadcrumb.name }}</button>
          <span v-if="index !== breadcrumbs.length - 1"> → </span>
        </span>
      </div>
  
      <div class="back-button">
        <button @click="goBack" :disabled="breadcrumbs.length === 0">Назад</button>
      </div>
  
      <!-- Форма для сортировки категорий и товаров -->
      <div class="sort-form">
        <label for="sort">Сортировать по:</label>
        <select v-model="sortOrder" @change="fetchCategory(currentCategoryId)">
          <option value="alpha_asc">Алфавит (по возрастанию)</option>
          <option value="alpha_desc">Алфавит (по убыванию)</option>
          <!-- Сортировка по цене доступна только если есть товары -->
          <option v-if="products.length > 0" value="price_asc">Цена (по возрастанию)</option>
          <option v-if="products.length > 0" value="price_desc">Цена (по убыванию)</option>
        </select>
      </div>
  
      <!-- Список подкатегорий -->
      <div v-if="categories.length > 0" class="categories">
        <h3>Категории</h3>
        <div v-for="category in categories" :key="category.id" class="category">
          <button @click="fetchCategory(category.id)">{{ category.name }}</button>
        </div>
      </div>
  
      <!-- Список товаров -->
      <div v-if="products.length > 0" class="products">
        <h3>Товары</h3>
        <ul>
          <li v-for="product in products" :key="product.id">{{ product.name }} - {{ product.price }}₽</li>
        </ul>
      </div>
    </div>
  </template>
  
  <style scoped>
  .catalog {
    padding: 20px;
    font-family: Arial, sans-serif;
  }
  
  .breadcrumbs {
    margin-bottom: 20px;
    font-size: 14px;
  }
  
  .breadcrumbs button {
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
    font-weight: bold;
    margin-right: 5px;
  }
  
  .breadcrumbs button:hover {
    text-decoration: underline;
  }
  
  .back-button {
    margin-bottom: 20px;
  }
  
  .back-button button {
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .back-button button:hover {
    background-color: #e9e9e9;
  }
  
  .categories, .products {
    margin-top: 20px;
  }
  
  .categories h3, .products h3 {
    font-size: 18px;
    margin-bottom: 15px;
    color: #333;
  }
  
  .categories button {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #495057;
    cursor: pointer;
    text-align: left;
    margin-bottom: 10px;
    transition: background-color 0.3s ease;
  }
  
  .categories button:hover {
    background-color: #e9ecef;
  }
  
  .products ul {
    list-style: none;
    padding-left: 0;
  }
  
  .products li {
    padding: 12px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    margin-bottom: 10px;
  }
  
  .sort-form {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
  }
  
  .sort-form label {
    font-size: 14px;
    margin-right: 10px;
  }
  
  .sort-form select {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    transition: border-color 0.3s ease;
  }
  
  .sort-form select:hover {
    border-color: #007bff;
  }
  </style>
  