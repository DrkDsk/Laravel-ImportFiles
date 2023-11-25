<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    brandsCollection: Object,
    category: Object,
});

const form = useForm({
    name: '',
    brand_id: null,
});

const submit = () => {
    form.post(route('dashboard.category.services.store', props.category.id));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Crear Servicios</h2>
        </template>

        <div class="flex flex-col justify-center mx-auto w-full md:w-8/12 items-center">
            <Head title="Crear Categorías" />

            <form @submit.prevent="submit" class="w-full rounded-lg border border-gray-200 shadow-md p-6">
                <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                    <div class="flex flex-col md:w-6/12 w-full">
                        <InputLabel for="name" value="Nombre" />

                        <TextInput type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="flex flex-col md:w-6/12 w-full">
                        <InputLabel for="email" value="Marca" />

                        <select class="mt-1 block w-full" v-model="form.brand_id" required autocomplete="username">
                            <option v-for="brand in brandsCollection.data" :value="brand.id">{{ brand.name }}</option>
                        </select>

                        <InputError class="mt-2" :message="form.errors.brand_id" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4 text-white bg-indigo-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Guardar
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
