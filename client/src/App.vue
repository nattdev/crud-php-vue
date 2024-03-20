<script setup>
import { ref, provide } from 'vue';
import { RouterView } from 'vue-router';

const users = ref([]);
provide('users', { users, getUsers });

async function getUsers() {
  const URL = "http://localhost/crud-php-vue/api/read.php";
  const response = await fetch(URL);
  const data = await response.json();
  users.value = data;
}

getUsers();
</script>

<template>
  <div class="p-5">
    <div class="flex items-center">
      <h1 class="text-2xl font-semibold mr-4 min-w-56">{{$route.fullPath == '/' ? "CRUD-PHP-VUE": "USUARIOS"}}</h1>
      <nav class="flex flex-row p-4 gap-6 text-stone-500">
        <router-link to="/">Home</router-link>
        <router-link to="/register">Registrar Usuario</router-link>
        <router-link to="/users">Ver Usuarios</router-link>
      </nav>
    </div>
    <main>
      <RouterView />
    </main>
    <footer class="bg-slate-50">
      <div class="dev-info flex gap-3 font-light">
          <p>Current route path: <span class="font-semibold">{{ $route.fullPath }} </span></p>
          <p>Current params route path: <span class="font-semibold">{{ $route.params.id }} </span></p>
      </div>
    </footer>
  </div>
</template>

<style scoped></style>
