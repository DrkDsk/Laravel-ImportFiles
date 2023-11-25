<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import { readonly } from 'vue';
import Multiselect from '@vueform/multiselect';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

let props = defineProps({
    userRole: Object,
    roles: Object,
    user: Object,
    brands: Object,
    userBrands: Object,
});

const optionsBrand = [];
readonly(props.brands.map((brand) => optionsBrand.push({ value: brand.id, label: brand.name })));

const selectedOptionsBrand = [];
readonly(props.userBrands.map((brand) => selectedOptionsBrand.push({ value: brand.id, label: brand.name })));

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.userRole.id,
    brand: selectedOptionsBrand,
});

function submit() {
    router.put(route('dashboard.users.update', props.user.id), form);
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>
    <Head title="Admin - Editar usuario" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Editar Usuario</h2>
        </template>
        <div class="flex flex-col justify-center mx-auto w-full items-center">
            <form @submit.prevent="submit" class="w-full rounded-lg border border-gray-200 shadow-md p-6">
                <p class="text-xl mb-3" style="font-weight: 700; font-size: 24px;">Edición de datos de usuario</p>
                <p class="font-thin text-sm text-gray-400">
                    Accede a la sección de edición de datos para actualizar la
                    información del colaborador existente. Modifica los campos
                    necesarios y guarda los cambios para mantener actualizada
                    la información en el CRM.
                </p>
                <div class="flex flex-col md:w-8/12 mt-4">
                    <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                        <div class="flex flex-col md:w-6/12 w-full">
                            <InputLabel for="name" value="Nombre" />

                            <input
                                id="name"
                                type="text"
                                class="mt-1 block border-gray-300 rounded-md"
                                v-model="form.name"
                                required
                                name="name"
                                autofocus
                                autocomplete="name"
                            />
                        </div>

                        <div class="flex flex-col md:w-6/12 w-full">
                            <InputLabel for="name" value="Correo Electrónico" />

                            <input
                                id="email"
                                type="text"
                                class="mt-1 block border-gray-300 rounded-md"
                                v-model="form.email"
                                required
                                name="email"
                                autofocus
                                autocomplete="username"
                            />
                        </div>
                    </div>
                    <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                        <div class="flex flex-col md:w-6/12 w-full">
                            <InputLabel for="role" value="Rol" />

                            <select class="mt-1 items-center flex bg-white border-gray-300 rounded-md" v-model="form.role" id="role" name="role">
                                <option selected v-for="role in roles" v-bind:key="role" :value="role.id">
                                    {{ role.name }}
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-col md:w-6/12 w-full">
                            <InputLabel for="brand" value="Marca" class="mb-1" />
                            <Multiselect
                                :selected="selectedOptionsBrand"
                                v-model="form.brand"
                                :taggable="true"
                                :options="optionsBrand"
                                searchable
                                mode="tags"
                            />
                        </div>
                    </div>
                    <div class="flex items-center justify-start mt-4">
                        <button type="submit" class="py-2 px-6 bg-black text-white rounded-3xl">
                            <div class="flex flex-row gap-4">
                                <img src="/assets/img/outline-save-as.svg" alt="">
                                <span class="uppercase text-sm">Guardar Cambios</span>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
