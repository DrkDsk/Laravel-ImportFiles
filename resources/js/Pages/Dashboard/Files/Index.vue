<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2'

let props = defineProps({
    files: Object,
    message: String,
    status: Number
});

const deleteFile = (id) => {
    const alert = Swal.mixin({
        customClass: {
            confirmButton: 'px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2 ml-2',
            cancelButton: 'px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2 ml-2'
        },
        buttonsStyling: false
    })

    alert.fire({
        icon: 'warning',
        title: '¿Deseas borrar este archivo junto con sus registros?',
        confirmButtonText: 'Borrar',
        confirmButtonColor: '#000000',
        showCancelButton: true,
        cancelButtonText: `Cancelar`,
        cancelButtonColor: '#000000',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            router.visit(route('dashboard.files.destroy', id), {
                method: 'delete',
            })
        }
    })
}

</script>

<template>
    <Head title="Admin - Archivos" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Archivos importados</h2>
        </template>

        <div class="overflow-auto m-5 mx-auto">

            <div class="flex flex-row justify-end">
                <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2 ml-2"
                    :href="route('dashboard.files.index')">
                    <div class="flex flex-row gap-4">
                        <img src="/assets/img/update-now.svg" alt="">
                        <span class="uppercase">Actualizar lista</span>
                    </div>
                </Link>
                <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2 ml-2"
                    :href="route('dashboard.files.create')">
                    <img src="/assets/img/add_icon.svg" alt="">
                    <span class="uppercase">Cargar archivo</span>
                </Link>
            </div>

            <div class="p-2 rounded text-white font-bold mt-4" v-if="message"
                :class="{ 'bg-green-600': status === 200, 'bg-red-600': status !== 200 }">
                {{ message }}
            </div>

            <table class="w-full text-sm text-gray-800 table-auto font-bold mt-2">
                <thead class="text-left uppercase">
                    <tr>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            #
                        </th>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            Nombre
                        </th>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            Fecha de carga
                        </th>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            Fecha de fin de carga
                        </th>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            Origen
                        </th>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            No. registros
                        </th>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            Excepción
                        </th>
                        <th scope="col" class="py-4 px-2 text-gray-900">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y-8 divide-gray-100 border-gray-100">
                    <tr v-for="file in files" :key="file.id" class="bg-white" style="border-radius: 10px;">
                            <td>
                                <div class="text-sm py-4 px-2">
                                    <div class="font-medium text-gray-700">
                                        {{ file.id }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm py-4 px-2">
                                    <div class="font-medium text-gray-700">
                                        {{ file.fileName }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm py-4 px-2">
                                    <div class="font-medium text-gray-700">
                                        {{ file.start }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm py-4 px-2">
                                    <div class="font-medium text-gray-700">
                                        {{ file.finish }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm py-4 px-2">
                                    <div class="font-medium text-gray-700">
                                        {{ file.origin }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm py-4 px-2">
                                    <div class="font-medium text-gray-700">
                                        {{ file.count }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm py-4 px-2">
                                    <div class="font-medium text-gray-700">
                                        {{ file.exception ?? 'N/A' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-4">
                                    <div class="flex justify-center gap-4">
                                        <button @click="deleteFile(file.id)">
                                            <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M24 3C12.3 3 3 12.3 3 24C3 35.7 12.3 45 24 45C35.7 45 45 35.7 45 24C45 12.3 35.7 3 24 3ZM24 42C14.1 42 6 33.9 6 24C6 14.1 14.1 6 24 6C33.9 6 42 14.1 42 24C42 33.9 33.9 42 24 42Z" fill="#3E3E3E"/>
                                                <path d="M32.1 34.5L24 26.4L15.9 34.5L13.5 32.1L21.6 24L13.5 15.9L15.9 13.5L24 21.6L32.1 13.5L34.5 15.9L26.4 24L34.5 32.1L32.1 34.5Z" fill="#3E3E3E"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>

    </AuthenticatedLayout>
</template>
