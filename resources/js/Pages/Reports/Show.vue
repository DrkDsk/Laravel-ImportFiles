<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { downloadFile } from '@/Services/FileService';

let props = defineProps({
    fileExport: {
        type: Object
    },
    medium: {
        type: Object
    },
    brands: {
        type: Object
    },
    origins: {
        type: Object
    },
    originName: {
        type: String
    },
    mediumName: {
        type: String
    }
})

const filePath = props.fileExport.filePath

const handleDonwload = () => {
    downloadFile(props.fileExport.id)
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="flex flex-row items-end gap-4 w-full rounded-md shadow-lg border p-4 mt-10">
            <div class="flex flex-col w-1/2">
                <p class="text-gray-700 font-semibold text-2xl">Medio: {{mediumName}}</p>

                <div class="flex flex-row justify-between w-full">
                    <div class="flex-col">
                        <p>Marcas:</p>
                        <p v-for="(data, index) in brands" v-bind:id="index">
                            {{index+1}} : {{data.name}}
                        </p>
                    </div>

                    <div class="flex-col">
                        <p>{{originName}}:</p>
                        <p v-for="(data, index) in origins" v-bind:id="index">
                            {{index+1}} : {{data.name}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="ml-8">
                <button v-if="filePath" @click="handleDonwload" class="flex flex-row items-center gap-2 font-medium text-white bg-black px-3 py-1.5 rounded-3xl">
                    <img src="/assets/img/outline-save.svg" alt=""> Descargar
                </button>
                <p v-else class="text-slate-800 text-lg italic">Tu archivo aún se encuentra procesando, revisa más tarde</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
