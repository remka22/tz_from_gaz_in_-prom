<template>
    <div class="category">
        <h3 class="category-name">{{ parent_o }} {{ category.name }}</h3>
        <div v-if="category.children_recursive && category.children_recursive.length" class="subcategories">
            <ul class="subcategory-list">
                <li v-for="subCategory in category.children_recursive" :key="subCategory.id">
                    <CategoryList :category="subCategory" :parent_order="parent_o" />
                </li>
            </ul>
        </div>
        <div v-else-if="category.products && category.products.length" class="products">
            <ul class="product-list">
                <li v-for="product in category.products" :key="product.id" class="product-item">
                    {{ product.name }} - <span class="product-price">{{ product.price }} ₽</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { defineProps, ref } from 'vue';

const props = defineProps<{
    category: {
        id: number;
        name: string;
        order: number;
        children_recursive: Array<{
            id: number;
            name: string;
            products: Array<{
                id: number;
                name: string;
                price: number;
            }>;
        }>;
        products: Array<{
            id: number;
            name: string;
            price: number;
        }>;
    };
    parent_order: string;
}>();
let parent_o = ref('');
if (!props.parent_order) {
    parent_o.value = props.category.order.toString();
} else {
    parent_o.value = props.parent_order + '-' + props.category.order.toString();
}
</script>

<style scoped>
.category {
    margin: 20px 0;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    background-color: #f9f9f9;
}

.category-name {
    font-size: 1.5em;
    color: #333;
    margin-bottom: 10px;
}

.subcategories,
.products {
    margin-top: 10px;
}

.subcategory-title,
.product-title {
    font-size: 1.2em;
    color: #555;
}

.subcategory-list,
.product-list {
    list-style-type: none;
    padding-left: 0;
}

.product-item {
    padding: 5px 0;
    color: #444;
}

.product-price {
    font-weight: bold;
    color: #007bff;
}
</style>