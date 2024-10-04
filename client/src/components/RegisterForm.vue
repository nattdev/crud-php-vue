<script setup>
import { inject, ref, watch } from 'vue';
import { useRoute } from 'vue-router';

const { getUsers } = inject('users');

const HOST = import.meta.env.VITE_BACKEND_URL || "http://localhost";

const name = ref("");
const age = ref();
const email = ref("");

const route = useRoute();

const loading = ref(false);
const successMessage = ref("");
const showSuccessMessage = ref(false);

async function createUser() {
    const URL = `${HOST}/crud-php-vue/api/create.php`;
    const data = {
        nombre: name.value,
        edad: age.value,
        email: email.value
    }
    return await fetch(URL, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
}

async function updateUser() {
    const URL = `${HOST}/crud-php-vue/api/update.php`;
    const data = {
        id: parseInt(route.params.id),
        nombre: name.value,
        email: email.value
    }
    return await fetch(URL, {
        method: "PUT",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
}

async function submitForm() {
    try {
        loading.value = true;
        if (route.params.id) {
            const response = await updateUser();
            console.log(response.status);
            response.status == 200 ? successMessage.value = "El usuario fue actualizado exitosamente" : "";
        } else {
            const response = await createUser();
            response.status == 201 ? successMessage.value = "El usuario fue creado exitosamente" : "";
        }
        showSuccessMessage.value = true;

    } catch (error) {
        console.error('Error al crear/actualizar el usuario:', error);
        successMessage.value = 'Error al guardar el usuario';
    } finally {
        loading.value = false;
        setTimeout(() => {
            showSuccessMessage.value = false;
        }, 2500);
        if (route.params.id) {
            getUsers();
        } else {
            clearFields();
            getUsers();
        }
    }
}

async function loadUser() {
    const URL = `${HOST}/crud-php-vue/api/read.php?id=${route.params.id}`;
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
    <div class="bg-[#FBFCFF] rounded-xl flex items-center flex-col sm:px-12 py-6 md:flex-row">
        <form class="flex flex-col pr-9 pb-6 px-3 text-lg flex-grow gap-2 w-full md:w-fit leading-none"
            @submit.prevent="submitForm">
            <label class="font-semibold p-1" for="GET-name">Nombre</label>
            <input class="p-1 border-b-slate-200 border-b-2" id="GET-name" v-model="name" type="text" name="name"
                required />
            <label class="font-semibold p-1" for="GET-age" v-if="!$route.params.id">Edad</label>
            <input class="p-1 border-b-slate-200 border-b-2" id="GET-age" v-model="age" type="number" name="age"
                v-if="!$route.params.id" />
            <label class="font-semibold p-1" for="GET-email">Email</label>
            <input class="p-1 border-b-slate-200 border-b-2" id="GET-email" v-model="email" type="email" name="email"
                required />
            <input
                class="py-1 px-6 mt-3 border-2 rounded-3xl w-fit cursor-pointer border-slate-600 text-slate-600 font-semibold text-base hover:bg-slate-600 hover:text-white transition-colors disabled:bg-slate-200 disabled:border-slate-200 disabled:text-slate-300 disabled:hover:bg-none disabled:hover:text-slate-300"
                type="submit" value="GUARDAR" :disabled="loading" /><span v-show="showSuccessMessage"
                :class="{ 'text-green-700 font-medium': successMessage && successMessage.includes('creado'), 'text-amber-700 font-medium': successMessage && successMessage.includes('actualizado') }">{{
                successMessage }}</span>
        </form>
        <div id="preview-card-user"
            class="flex overflow-hidden flex-col justify-center h-fit p-6 items-center gap-2 bg-white shadow-md rounded-xl md:w-2/5 w-full break-words text-center mb-4 sm:mb-0">
            <p class="font-semibold mb-2">Nuevo Usuario</p>
            <img class="min-w-16 min-h-5 rounded-full" src="../assets/avatar/avatar.svg" />
            <p class="mt-3 min-h-6 max-w-full max-auto text-xl overflow-y-auto">{{ name }}</p>
            <p class="min-h-6 max-w-full max-h-12 overflow-y-auto">{{ age ? `${age} años` : "" }}</p>
            <p class="min-h-6 max-w-full max-h-12 overflow-y-auto">{{ email }}</p>
        </div>
    </div>
</template>