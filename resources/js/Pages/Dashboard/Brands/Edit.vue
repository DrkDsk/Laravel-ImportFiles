<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

let props = defineProps({
    brand : Object
})

const form = reactive({
    _method : 'put',
    title : props.brand.title,
    description : props.brand.description,
    image : null
})

function submit () {
    router.post(route('dashboard.brands.update', props.brand.id), form)
}

function deleteBrand () {
    router.delete(route('dashboard.brands.destroy', props.brand.id))
}

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>

        <section class="text-gray-600 body-font">
            <div class="container px-5 py-5 mx-auto w-8/12">
                <div class="bg-white rounded-md shadow-lg">

                    <div class="flex flex-row justify-between p-5">
                        <p class="text-lg font-bold text-black">Editar marca</p>
                        <button v-on:click="deleteBrand" class="shadow bg-red-600 hover:bg-red-500 focus:shadow-outline focus:outline-none text-white text-md py-2 px-4 rounded">
                            Eliminar marca
                        </button>
                    </div>
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div class="flex flex-col py-2 px-4 gap-2">
                            <label>Título</label>
                            <input type="text" v-model="form.title" class="rounded-md border-1 border-gray-200 w-6/12">
                            <p v-if="!form.title" class="text-red-500 font-semibold">Ingresa un título</p>
                            <label>Descripción</label>
                            <input type="text" v-model="form.description" class="rounded-md border-1 border-gray-200 w-6/12">
                            <label>Nombre Interno</label>
                            <input type="text" disabled readonly v-model="props.brand.name" class="rounded-md border-1 border-gray-200 w-6/12">
                            <label for="image" class="mt-2">Imagen</label>
                            <input type="file" id="image" @input="form.image = $event.target.files[0]">
                        </div>
                        <div class="flex flex-row justify-end mt-4 p-4">
                            <button :disabled="!form.title" :class="{ 'bg-gray-500' : !form.title, 'bg-green-600 hover:bg-green-500' : form.title }" type="submit" class="shadow focus:shadow-outline focus:outline-none text-white text-md py-2 px-4 rounded">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>
