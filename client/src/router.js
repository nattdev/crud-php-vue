import { createMemoryHistory, createRouter, createWebHashHistory } from 'vue-router';

import HomeView from './views/HomeView.vue';
import NotFound from './views/NotFound.vue';
import RegisterForm from './components/RegisterForm.vue';
import UsersTable from './components/UsersTable.vue';

const routes = [
  { path: '/', component: HomeView },
  { path: '/register', component: RegisterForm },
  { path: '/users', component: UsersTable },
  { path: '/users/:id', component: RegisterForm },
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
})

export default router