<script setup>
import { ref } from 'vue';
const users = ref([]);

async function getUsers() {
    const URL = "http://localhost/crud-php-vue/api/read.php";
    const response = await fetch(URL);
    const data = await response.json();
    users.value = data;
}

getUsers();

async function deleteUser(id) {
    console.log("eliminar", id);
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


</script>

<template>
    <div v-for="user in users">
        <p>ID: {{ user.id }}</p>
        <p>Nombre: {{ user.nombre }}</p>
        <p>Edad: {{ user.edad }}</p>
        <p>Email: {{ user.email }}</p>
        <button @click="deleteUser(user.id)">DELETE</button>
        <button>UPDATE</button>
    </div>
</template>