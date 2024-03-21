<script setup>
import { ref, provide } from 'vue';
import { useRoute, RouterView } from 'vue-router';

const route = useRoute();

const users = ref([]);
provide('users', { users, getUsers });

async function getUsers() {
  const URL = "http://localhost/crud-php-vue/api/read.php";
  const response = await fetch(URL);
  const data = await response.json();
  users.value = data;
}

getUsers();

function pathName() {
  if(route.fullPath == '/') {
    return "CRUD-PHP-VUE";
  } else if(route.fullPath == '/register') {
    return "REGISTRAR USUARIO";
  } else if(route.fullPath == `/users/${route.params.id}`) {
    return "ACTUALIZAR USUARIO";
  } else {
    return "USUARIOS";
  }
}

</script>

<template>
  <div class="p-5 min-h-screen flex flex-col">
    <div class="flex items-start sm:items-center sm:flex-row flex-col px-3 sm:px-0">
      <h1 class="text-2xl font-semibold mr-0 min-w-none sm:mr-4 sm:min-w-60">{{pathName()}}</h1>
      <nav class="flex flex-col items-start sm:items-center sm:flex-row sm:p-4 py-4 sm:gap-6 gap-3 text-slate-500 ba font-normal">
        <router-link to="/">Inicio</router-link>
        <router-link to="/register">Registrar Usuario</router-link>
        <router-link to="/users">Mostrar Usuarios</router-link>
      </nav>
    </div>
    <main class="sm:mt-6 mt-1">
      <RouterView />
    </main>
    <footer class="bg-slate-50 mt-auto">
      <div class="dev-info flex font-light bottom-0 flex-wrap">
          <p class="w-full font-semibold">Dev info:</p>
          <p>Current route path: <span class="font-semibold pr-6">{{ $route.fullPath }} </span></p>
          <p>Current params route path: <span class="font-semibold">{{ $route.params.id }} </span></p>
      </div>
    </footer>
  </div>
</template>

<style scoped></style>
