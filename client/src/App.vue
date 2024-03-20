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
  <div class="p-5">
    <div class="flex items-center">
      <h1 class="text-2xl font-semibold mr-4 min-w-56">{{pathName()}}</h1>
      <nav class="flex flex-row p-4 gap-6 text-stone-500">
        <router-link to="/">Home</router-link>
        <router-link to="/register">Registrar Usuario</router-link>
        <router-link to="/users">Ver Usuarios</router-link>
      </nav>
    </div>
    <main class="mt-6">
      <RouterView />
    </main>
    <footer class="bg-slate-50 m-3">
      <div class="dev-info flex font-light bottom-0 flex-wrap">
          <p class="w-full font-semibold">Dev info:</p>
          <p>Current route path: <span class="font-semibold pr-6">{{ $route.fullPath }} </span></p>
          <p>Current params route path: <span class="font-semibold">{{ $route.params.id }} </span></p>
      </div>
    </footer>
  </div>
</template>

<style scoped></style>
