<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";

let form = useForm({
    name : ''
})

const createPackage = () => {
    form.post(route('dashboard.packages.store'))
}


</script>

<template>
    <AuthenticatedLayout>

        <div class="flex flex-col w-full p-4">
            <h2 class="font-semibold text-xl leading-tight my-5">Registro de paquetes</h2>

            <div class="container px-5 py-5 mx-auto w-8/12">
                <div class="bg-white rounded-md shadow-lg">
                    <form @submit.prevent="createPackage">
                        <div class="flex flex-col py-2 px-4">
                            <InputLabel for="name" value="Nombre" />
                            <input type="text" v-model="form.name" class="mt-2 rounded-md border-1 border-gray-200 w-6/12">
                            <div class="flex flex-row justify-end mt-4">
                                <button type="submit" :disabled="form.processing" class="py-2 px-6 bg-black text-white rounded-3xl">
                                    <div class="flex flex-row gap-4">
                                        <img src="/assets/img/outline-save.svg" alt="">
                                        <span class="uppercase text-sm">Guardar</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
