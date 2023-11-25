<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

let props = defineProps({
    users: Object
});

</script>

<template>
    <Head title="Admin - Usuarios" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Usuarios</h2>
        </template>

        <div class="overflow-auto m-5 mx-auto">

            <div class="flex flex-row justify-end">
                <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2"
                    :href="route('dashboard.users.create')">
                    <img src="/assets/img/add_icon.svg" alt="">
                    <span>Añadir Usuario</span>
                </Link>
            </div>

            <table class="w-full text-sm text-gray-800 table-auto font-bold">
                <thead class="text-left uppercase">
                    <tr>
                        <th scope="col" class="py-4 text-gray-900">
                            Nombre
                        </th>
                        <th scope="col" class="py-4 text-gray-900">
                            Role
                        </th>
                        <th scope="col" class="text-center py-4 text-gray-900">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y-8 divide-gray-100 border-gray-100">
                    <tr v-for="user in users" :key="user.id" class="bg-white" style="border-radius: 10px;">
                        <td>
                            <div class="text-sm py-2 px-4">
                                <div class="font-medium text-gray-700">
                                    {{ user.name }}
                                </div>
                            </div>
                        </td>
                        <td v-if="user.roles.length">
                            <div class="text-sm py-2" v-for="role in user.roles" :key="role.id">
                                <div class="font-medium text-gray-700 capitalize">
                                    {{ role.name }}
                                </div>
                            </div>
                        </td>
                        <td v-else>
                            <p> Sin roles</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-4">
                                <Link :href="route('dashboard.users.edit', user)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="h-6 w-6" x-tooltip="tooltip">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </AuthenticatedLayout>
</template>
