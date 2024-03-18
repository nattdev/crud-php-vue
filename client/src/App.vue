<script setup>
import { ref, provide} from 'vue';
import { RouterView } from 'vue-router';

const users = ref([]);
provide('users', {users, getUsers});

async function getUsers() {
    const URL = "http://localhost/crud-php-vue/api/read.php";
    const response = await fetch(URL);
    const data = await response.json();
    users.value = data;
}

getUsers();
</script>

<template>
  <div>
    <h1>Hello App!</h1>
    <router-link to="/">Home</router-link><br>
    <router-link to="/register">Registrar Usuario</router-link><br>
    <router-link to="/users">Ver Usuarios</router-link><br>
    <p>
      <strong>Current route path:</strong> {{ $route.fullPath }}
      <strong>Current params route path:</strong> {{ $route.params.id }}
    </p>
  </div>
  <main>
    <RouterView />
  </main>
</template>

<style scoped></style>
