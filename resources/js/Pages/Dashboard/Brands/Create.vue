<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    title: '',
    name: '',
    image : '',
    description: ''
});

const submit = () => {
    form.post(route('dashboard.brands.store'), {
    });
};

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>

        <section class="text-gray-600 body-font">
            <div class="container px-5 py-5 mx-auto w-8/12">
                <div class="bg-white rounded-md shadow-lg">
                    <p class="text-lg font-bold text-black p-4">Registrar marca</p>
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div class="flex flex-col py-2 px-4">
                            <label for="name">Título</label>
                            <input type="text" v-model="form.title" class="rounded-md border-1 border-gray-200 w-6/12">
                            <label>Descripción</label>
                            <input type="text" v-model="form.description" class="rounded-md border-1 border-gray-200 w-6/12">
                            <label>Nombre Interno</label>
                            <input type="text" v-model="form.name" class="rounded-md border-1 border-gray-200 w-6/12">
                            <label for="image" class="mt-2">Imagen</label>
                            <input type="file" id="image" @input="form.image = $event.target.files[0]">
                        </div>
                        <div class="flex flex-row justify-end mt-4 p-4">
                            <button type="submit" class="shadow bg-green-600 hover:bg-green-500 focus:shadow-outline focus:outline-none text-white text-md py-2 px-4 rounded">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
    <!--  -->
</template>
