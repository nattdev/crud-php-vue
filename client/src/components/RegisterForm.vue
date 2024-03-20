<script setup>
import { inject, ref, watch } from 'vue';
import { useRoute } from 'vue-router';

const { getUsers } = inject('users');

const name = ref("");
const age = ref();
const email = ref("");

const route = useRoute();

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
    clearFields();
    getUsers();
}

async function updateUser() {
    const URL = "http://localhost/crud-php-vue/api/update.php";
    const data = {
        id: parseInt(route.params.id),
        nombre: name.value,
        email: email.value
    }
    const response = await fetch(URL, {
        method: "PUT",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
    getUsers();
}

function submitForm() {
    if (route.params.id) {
        updateUser();
    } else {
        createUser();
    }
}

async function loadUser() {
    const URL = `http://localhost/crud-php-vue/api/read.php/${route.params.id}`;
    const response = await fetch(URL);
    const data = await response.json();

    name.value = data[0].nombre;
    age.value = data[0].edad;
    email.value = data[0].email;
}

function clearFields() {
    name.value = "";
    age.value = "";
    email.value = "";
}

watch(() => route.path, (newPath, oldPath) => {
    if (newPath === '/register') {
        clearFields();
    }
});

if (route.params.id) {
    loadUser();
}

</script>
<template>

    <h2>{{ $route.params.id ? "Update User" : "Create User" }}</h2>

    <form @submit.prevent="submitForm">
        <label for="GET-name">Nombre:</label>
        <input id="GET-name" v-model="name" type="text" name="name" required />
        <label for="GET-age" v-if="!$route.params.id">Edad:</label>
        <input id="GET-age" v-model="age" type="number" name="age" v-if="!$route.params.id"/>
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