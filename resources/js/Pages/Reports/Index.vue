<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, router} from "@inertiajs/vue3";
import {downloadFile} from "@/Services/FileService";

let props = defineProps({
    files: {
        type: Object
    }
})

const showFileExport = (file_id) => {
    router.get(route('dashboard.fileExport.show', file_id))
}

const handleDonwload = (file_id) => {
    downloadFile(file_id)
}

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Archivos exportados</h2>
        </template>


        <div class="overflow-auto m-5 mx-auto">

            <div class="flex flex-row justify-end">
                <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2 ml-2"
                      :href="route('dashboard.fileExport.index')">
                    <div class="flex flex-row gap-4">
                        <img src="/assets/img/update-now.svg" alt="">
                        <span class="uppercase">Actualizar lista</span>
                    </div>
                </Link>
            </div>

            <table class="w-full text-sm text-gray-800 table-auto font-bold mt-2">
                <thead class="text-left uppercase">
                <tr>
                    <th scope="col" class="py-4 text-gray-900">
                        #
                    </th>
                    <th scope="col" class="py-4 text-gray-900">
                        Medio
                    </th>

                    <th scope="col" class="py-4 text-gray-900">
                        Fecha de exportación
                    </th>

                    <th scope="col" class="py-4 text-gray-900">
                        Estado
                    </th>

                    <th scope="col" class="py-4 text-gray-900">
                        Opciones
                    </th>

                </tr>
                </thead>
                <tbody class="divide-y-8 divide-gray-100 border-gray-100">
                <tr v-for="file in files" :key="file.id" class="bg-white" style="border-radius: 10px;">
                    <td>
                        <div class="text-sm py-4">
                            <div class="font-medium text-gray-700">
                                {{ file.id }}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-sm py-4">
                            <div class="font-medium text-gray-700">
                                {{ file.medium.name }}
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="text-sm py-4">
                            <div class="font-medium text-gray-700">
                                {{ file.startDate }}
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="text-sm py-4">
                            <button @click="handleDonwload(file.id)" v-if="file.filePath !== ''" class="flex flex-row items-center gap-2 font-medium text-white bg-black px-3 py-1.5 rounded-3xl">
                                <img src="/assets/img/outline-save.svg" alt=""> Descargar
                            </button>

                            <div v-else class="font-medium text-amber-500">
                                Procesando archivo
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="flex gap-4">
                            <button @click="deleteFile(file.id)">
                                <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24 3C12.3 3 3 12.3 3 24C3 35.7 12.3 45 24 45C35.7 45 45 35.7 45 24C45 12.3 35.7 3 24 3ZM24 42C14.1 42 6 33.9 6 24C6 14.1 14.1 6 24 6C33.9 6 42 14.1 42 24C42 33.9 33.9 42 24 42Z" fill="#3E3E3E"/>
                                    <path d="M32.1 34.5L24 26.4L15.9 34.5L13.5 32.1L21.6 24L13.5 15.9L15.9 13.5L24 21.6L32.1 13.5L34.5 15.9L26.4 24L34.5 32.1L32.1 34.5Z" fill="#3E3E3E"/>
                                </svg>
                            </button>

                            <button class="bg-black text-white rounded-3xl px-3 py-2" @click="showFileExport(file.id)">
                                Ver detalles
                            </button>
                        </div>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
