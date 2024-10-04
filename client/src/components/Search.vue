<script setup>
import { inject, ref } from 'vue';

const users = inject('users');

const searchTerm = ref("");
const filteredItems = ref([]);
const successMessage = ref("");

function normalizeString(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
}

function searchFilter() {

    const normalizedSearchTerm = normalizeString(searchTerm.value);

    filteredItems.value = users.value.filter(user => normalizeString(user.nombre.toLowerCase()).includes(normalizedSearchTerm.toLowerCase()));

    const totalItems = filteredItems.value.length;

    if (totalItems > 0) {
        successMessage.value = `Se encontraron ${totalItems} ${totalItems === 1 ? "coincidencia" : "coincidencias"}`;
    } else {
        successMessage.value = "No se encontraron resultados";
    }
}

function clearFilteredItems() {
    filteredItems.value = [];
    successMessage.value = "";
}

</script>

<template>
    <div class="py-2">
        <div class="flex flex-wrap justify-end">
            <form class="" role="search" @submit.prevent="searchFilter">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative flex items-center">
                    <div class="w-auto min-w-32">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input v-model="searchTerm" type="search" id="default-search"
                            class="flex-grow block w-auto p-1 pl-8 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar por nombre" required />
                    </div>
                    <button type="submit"
                        class="end-2.5 bottom-2.5 py-1 ml-3 px-3 border-2 rounded-3xl w-fit cursor-pointer border-slate-600 text-slate-600 font-semibold text-base hover:bg-slate-600 hover:text-white transition-colors disabled:bg-slate-200 disabled:border-slate-200 disabled:text-slate-300 disabled:hover:bg-none disabled:hover:text-slate-300">Buscar</button>
                </div>
            </form>
        </div>
        <div class="mt-4">
            <div class=" bg-slate-50 flex flex-col sm:p-0 sm:py-2 p-3  lg:grid md:grid-cols-[1fr_2fr_1fr_2fr_2fr] gap-y-2 relative break-words border-slate-200 border-b-[1px]"
                v-for="user in filteredItems">
                <p class="absolute right-0 pr-3 lg:relative lg:pr-0">{{ user.id }}</p>
                <p class=" font-semibold sm:text-lg text-xl">{{ user.nombre }}</p>
                <p class="">{{ user.edad }} años</p>
                <p class="">{{ user.email }}</p>
            </div>
        </div>
        <div class="mx-3 flex flex-col sm:flex-row items-center">
            <span>{{ successMessage }}</span>
            <button v-if="successMessage.length > 0" @click="clearFilteredItems()"
                class="box-border my-1.5 px-2.5 mx-0 sm:mx-3 border-2 rounded-3xl w-fit cursor-pointer border-slate-200 text-slate-600 font-semibold text-  hover:text-orange-700 transition-colors disabled:bg-slate-200 disabled:border-slate-200 disabled:text-slate-300 disabled:hover:bg-none disabled:hover:text-slate-300">Limpiar
                Búsqueda</button>
        </div>
    </div>
</template>