<script setup>
import { inject, ref } from 'vue';
import { useRoute } from 'vue-router';

const {getUsers} = inject('users');
console.log(getUsers);

const name = ref("");
const age = ref();
const email = ref("");

async function createUser() {
    const URL = "http://localhost/crud-php-vue/api/create.php";
    const data = {
        nombre: name.value,
        edad: age.value,
        email: email.value
    }
    const response = await fetch(URL, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })

    // Limpiar los campos del formulario después de enviarlos
    name.value = "";
    age.value = "";
    email.value = "";

    getUsers();
}

const route = useRoute();

if(route.params.id) {
    console.log("update");
}

</script>
<template>

    <h2>{{ $route.params.id ? "Update User" : "Create User"}}</h2>

    <form @submit.prevent="createUser">
        <label for="GET-name">Nombre:</label>
        <input id="GET-name" v-model="name" type="text" name="name" required/>
        <label for="GET-age">Edad:</label>
        <input id="GET-age" v-model="age" type="number" name="age" />
        <label for="GET-email">Email:</label>
        <input id="GET-email" v-model="email" type="email" name="email" required />
        <input type="submit" value="Save" />
    </form>

    <div id="preview-card-user">
        <p>Nombre de Usuario: {{ name }}</p>
        <p>Edad: {{ age }}</p>
        <p>Email: {{ email }}</p>
    </div>

</template>