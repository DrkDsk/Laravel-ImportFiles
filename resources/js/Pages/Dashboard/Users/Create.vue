<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Multiselect from '@vueform/multiselect';
import { readonly } from 'vue';
import { ref } from 'vue';

let props = defineProps({
    roles: Object,
    brands: Object,
});

const optionsBrand = [];

let passwordIcon = ref('/assets/img/mdi_eye.svg');
let passwordIsShowed = ref(true);
let passwordType = ref('password');

let passwordConfirmIcon = ref('/assets/img/mdi_eye.svg');
let passwordConfirmIsShowed = ref(true);
let passwordConfirmType = ref('password');

const showAndHidePassword = () => {
    passwordIsShowed.value = !passwordIsShowed.value;
    if (passwordIsShowed.value) {
        passwordType.value = 'password';
        passwordIcon.value = '/assets/img/mdi_eye.svg';
    } else {
        passwordType.value = 'text';
        passwordIcon.value = '/assets/img/mdi_eye-off.svg';
    }
};

const showAndHideConfirmPassword = () => {
    passwordConfirmIsShowed.value = !passwordConfirmIsShowed.value;
    if (passwordConfirmIsShowed.value) {
        passwordConfirmType.value = 'password';
        passwordConfirmIcon.value = '/assets/img/mdi_eye.svg';
    } else {
        passwordConfirmType.value = 'text';
        passwordConfirmIcon.value = '/assets/img/mdi_eye-off.svg';
    }
};
readonly(props.brands.map((brand) => optionsBrand.push({ value: brand.id, label: brand.name })));

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
    brand: null,
});

const submit = () => {
    form.post(route('dashboard.users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>
    <Head title="Crear Usuario" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Crear Usuario</h2>
        </template>

        <div class="flex flex-col justify-center mx-auto w-full items-center">
            <form @submit.prevent="submit" class="w-full rounded-sm border bg-white shadow-sm p-6">
                <p class="text-xl mb-3" style="font-weight: 700; font-size: 24px;">Alta de usuario</p>
                <p class="font-thin text-sm text-gray-400">
                    Completa los datos del nuevo usuario para darlo de alta en el CRM. Ingresa la información requerida y asegúrate de proporcionar los detalles
                    correctos para una gestión eficiente de la relación con el cliente.
                </p>
                <div class="flex flex-col md:w-8/12 mt-4">
                    <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                        <div class="flex flex-col w-full">
                            <InputLabel for="name" value="Nombre" />

                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="flex flex-col w-full">
                            <InputLabel for="email" value="Correo electrónico" />

                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                    </div>

                    <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                        <div class="flex flex-col w-full">
                            <InputLabel for="password" value="Contraseña" />

                            <div class="flex items-center border border-gray-300 bg-white px-3 rounded-md shadow-sm">
                                <input v-model="form.password" name="email" class="block w-full border-none" :type="passwordType" placeholder="" />
                                <button v-on:click="showAndHidePassword">
                                    <img :src="passwordIcon" alt="" />
                                </button>
                            </div>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex flex-col w-full">
                            <InputLabel for="password_confirmation" value="Confirmar contraseña" />

                            <div class="flex items-center border border-gray-300 bg-white px-3 rounded-md shadow-sm">
                                <input
                                    v-model="form.password_confirmation"
                                    name="email"
                                    class="block w-full border-none"
                                    :type="passwordConfirmType"
                                    placeholder=""
                                />
                                <button v-on:click="showAndHideConfirmPassword">
                                    <img :src="passwordConfirmIcon" alt="" />
                                </button>
                            </div>

                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                    </div>

                    <div class="flex gap-4 items-center flex-col md:flex-row my-4">
                        <div class="flex flex-col w-full">
                            <InputLabel for="role" value="rol" />

                            <select class="mt-1 items-center flex bg-white border-gray-300 rounded-md" v-model="form.role" id="id">
                                <option disabled value="">Seleccionar una opción</option>
                                <option v-for="role in roles" v-bind:key="role">
                                    {{ role.name }}
                                </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.role" />
                        </div>

                        <div class="flex flex-col w-full">
                            <InputLabel for="brand" value="Marca" class="mb-1" />
                            <Multiselect v-model="form.brand" :taggable="true" :options="optionsBrand" searchable mode="tags" placeholder="Seleccionar una opción"/>
                        </div>
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <button :disabled="form.processing" class="py-2 px-6 bg-black text-white rounded-3xl">
                            <div class="flex flex-row gap-4">
                                <img src="/assets/img/outline-save.svg" alt="">
                                <span class="uppercase text-sm">GUARDAR</span>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
