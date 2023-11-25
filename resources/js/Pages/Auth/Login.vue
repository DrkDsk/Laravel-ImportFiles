<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="flex min-h-screen">
        <div class="flex items-center justify-around w-1/2" style="background: linear-gradient(90deg, #FFE259 0%, #FFA751 100%);">
            <div class="flex flex-row justify-center px-4 py-2 lg:py-48 lg:mx-16" style="background: rgba(255, 255, 255, 0.45); border-radius: 8px; top: calc(50% - 700px/2);">
                <div class="flex flex-col gap-6 text-black lg:w-6/12">
                    <img src="assets/img/triangle.svg" alt="">
                    <p class="mt-1">Monitorear la presencia de tu marca en los medios y obtén información
                        valiosa para la toma de decisiones estratégicas.
                    </p>
                </div>
            </div>
        </div>
        <div class="flex justify-center w-1/2 bg-white">
            <form class="self-center w-8/12 bg-white" @submit.prevent="submit">
                <div class="mb-4">
                    <img src="assets/img/mediacorp.svg" alt="media corp">
                </div>
                <div class="flex flex-row items-center gap-1">
                    <h1 class="mb-1 text-2xl font-black text-gray-800">¡Hola!</h1>
                    <img src="assets/img/hand.svg" width="25" alt="">
                </div>
                <p class="text-sm font-normal text-gray-600 mb-7">Ingresa tus credenciales para acceder a nuestra plataforma
                </p>
                <p class="my-2 text-sm font-normal text-gray-600">Nombre de usuario o email</p>
                <input class="w-full pl-2 border-gray-300 rounded-md outline-none border-1" type="email" name="email"
                    v-model="form.email" id="email" required autofocus autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
                <p class="my-2 text-sm font-normal text-gray-600">Contraseña</p>
                <input class="w-full pl-2 border-gray-300 rounded-md outline-none border-1" type="password" name="password"
                    autocomplete="current-password" v-model="form.password" id="password" />
                <InputError class="mt-2" :message="form.errors.password" />
                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600">Recordar cuenta</span>
                    </label>
                </div>
                <button type="submit" class="block w-full py-2 mt-4 mb-2 text-black bg-yellow-500 rounded-2xl">Ingresar
                </button>
                <div class="flex flex-row justify-center my-6">
                    <Link class="text-center" :href="route('password.request')" v-if="canResetPassword">
                    <span class="ml-2 text-sm cursor-pointer hover:text-blue-500">Recuperar contraseña</span>
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
