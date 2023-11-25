<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

let props = defineProps({
    message: String,
    status: Number
});

const form = useForm({
    origin: '',
    file: null
});

const submit = () => {
    form.post(route('dashboard.files.store'));
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>
    <Head title="Importar archivo" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Importar Archivo</h2>
        </template>

        <div class="flex flex-col justify-center mx-auto w-full items-center">
            <form @submit.prevent="submit" class="w-full rounded-sm border bg-white shadow-sm p-6">
                <p class="text-xl mb-3" style="font-weight: 700; font-size: 24px;">Importación de archivo de movimientos</p>
                <p class="font-thin text-sm text-gray-400">
                    Es importante seleccionar el tipo de archivo para que ocupe el formato de importación correcto.
                </p>

                <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                    <div class="flex flex-col w-full">
                        <InputLabel for="type" value="Tipo de archivo de documento" />

                        <select class="mt-1 items-center flex bg-white border-gray-300 rounded-md" v-model="form.origin" id="type">
                            <option disabled value="">Seleccionar una opción</option>
                            <option value="OOH">OOH</option>
                            <option value="Prensa">Prensa</option>
                            <option value="Revista">Revista</option>
                        </select>

                        <InputError class="mt-2" :message="form.errors.origin" />
                    </div>
                </div>

                <div class="flex flex-col md:w-8/12 mt-4">
                    <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                        <div class="flex flex-col w-full">
                            <InputLabel for="file" value="Documento" />

                            <TextInput id="file" type="file" class="mt-1 block w-full" @input="form.file = $event.target.files[0]" required />

                            <InputError class="mt-2" :message="form.errors.file" />
                        </div>
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <button :disabled="form.processing" class="py-2 px-6 bg-black text-white rounded-3xl">
                            <div class="flex flex-row gap-4">
                                <img src="/assets/img/outline-save.svg" alt="">
                                <span class="uppercase text-sm">Importar</span>
                            </div>
                        </button>
                            <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2 ml-2"
                                :href="route('dashboard.files.index')">
                                <div class="flex flex-row gap-4">
                                    <span class="uppercase">Regresar</span>
                                </div>
                            </Link>
                    </div>

                    <div class="p-2 rounded text-white font-bold mt-4" v-if="message"
                        :class="{ 'bg-green-600': status === 200, 'bg-red-600': status !== 200 }">
                        {{message}}
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
