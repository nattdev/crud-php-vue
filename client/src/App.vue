<script setup>
import { RouterView } from 'vue-router';

import { useRoute, useRouter } from 'vue-router'

const location = useRoute();
const router = useRouter();

</script>

<template>
  <div>
    <h1>Hello App!</h1>
    <router-link to="/">Home</router-link><br>
    <router-link to="/register">Registrar Usuario</router-link><br>
    <router-link to="/users">Ver Usuarios</router-link><br>
    <p>
      <strong>Current route path:</strong> {{ $route.fullPath }}
      <strong>Current route path:</strong> {{ $route.params.id }}
    </p>
  </div>
  <main>
    <RouterView />
  </main>
</template>

<style scoped></style>
