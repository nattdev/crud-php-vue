<script setup>
import router from '@/router';
import { inject } from 'vue';
import Search from './Search.vue';

const users = inject('users');
const HOST = import.meta.env.VITE_BACKEND_URL || "http://localhost";

getUsers();

async function getUsers() {
  const URL = `${HOST}/crud-php-vue/api/read.php`;
  const response = await fetch(URL);
  const data = await response.json();
  users.value = data;
}

async function deleteUser(id) {
    const newUsers = users.value.filter(user => id !== user.id);
    users.value = newUsers;
    const URL = `${HOST}/crud-php-vue/api/delete.php`;
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
    <Search/>
    <div class="w-full">
        <div class="text-left text-lg hidden lg:grid lg:grid-cols-[1fr_2fr_1fr_2fr_2fr] border-y border-slate-300 font-light my-2">
            <p>ID</p>
            <p>Nombre</p>
            <p>Edad</p>
            <p>Email</p>
            <p>Acciones</p>
        </div>
        <div class=" bg-[#FBFCFF] flex flex-col sm:p-0 sm:py-2 p-3 my-2 rounded-xl lg:grid md:grid-cols-[1fr_2fr_1fr_2fr_2fr] gap-y-2  relative break-words" v-for="user in users">
            <p class="absolute right-0 pr-3 lg:relative lg:pr-0">{{ user.id }}</p>
            <p class=" font-semibold sm:text-lg text-xl">{{ user.nombre }}</p>
            <p class="">{{ user.edad }} años</p>
            <p class="">{{ user.email }}</p>
            <p class="min-w-72">
                <button
                    class="mr-5 px-3 border-2 rounded-3xl w-fit cursor-pointer border-green-500 text-green-500 font-semibold text-base"
                    @click="navigateToUpdateUser(user.id)">EDITAR</button>
                <button
                    class="mr-5 px-3 border-2 rounded-3xl w-fit cursor-pointer border-orange-700 text-orange-700 font-semibold text-base"
                    @click="deleteUser(user.id)">ELIMINAR</button>
            </p>
        </div>
    </div>
</template>