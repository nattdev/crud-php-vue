<script setup>
import router from '@/router';
import { ref, inject } from 'vue';

// const users = ref([]);
const { users } = inject('users');

async function deleteUser(id) {
    console.log("eliminar", id);
    const newUsers = users.value.filter(user => id !== user.id);
    users.value = newUsers;
    const URL = "http://localhost/crud-php-vue/api/delete.php";
    const data = {
        id: parseInt(id),
    }

    const response = await fetch(URL, {
        method: "DELETE",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    });
}

function navigateToUpdateUser(id) {
    router.push(`/users/${id}`)
}

</script>

<template>
    <div v-for="user in users">
        <p>ID: {{ user.id }}</p>
        <p>Nombre: {{ user.nombre }}</p>
        <p>Edad: {{ user.edad }}</p>
        <p>Email: {{ user.email }}</p>
        <button @click="deleteUser(user.id)">DELETE</button>
        <button @click="navigateToUpdateUser(user.id)">UPDATE</button>
    </div>
</template>