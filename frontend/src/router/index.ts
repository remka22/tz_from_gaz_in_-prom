import { createRouter, createWebHistory } from 'vue-router'
import Reports from '../views/Reports.vue'
import CategoriesView from '../views/CategoriesView.vue';
import FullListView from '../views/FullListView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/categories',
      name: 'categories',
      component: CategoriesView
    },
    {
      path: '/full-list',
      name: 'full-list',
      component: FullListView
    },
    {
      path: '/reports',
      name: 'reports',
      component: Reports
    }
  ]
})

export default router
