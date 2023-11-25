<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {setDefaultImageBrand} from "@/Services/FileService";

const props = defineProps({
    brands : Object,
    baseUrl: String
})

const handleErrorImage = (e) => setDefaultImageBrand(e)

</script>

<template>
    <Head title="Marcas" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Marcas</h2>
        </template>

        <section class="text-gray-600 body-font">
            <div class="p-4 mx-auto bg-white rounded-sm shadow-md">
                <div class="flex flex-row justify-end">
                    <Link
                        :href="route('dashboard.brands.create')"
                        class="shadow bg-blue-800 hover:bg-blue-700 focus:shadow-outline focus:outline-none text-white text-md py-2 px-4 rounded">
                        Registrar marca
                    </Link>
                </div>
                <p class="text-lg font-bold text-black">Marcas registradas</p>
                <p class="text-sm font-semibold text-gray-500">Administra todas las marcas</p>
                <div class="flex flex-wrap mt-2">
                    <div class="p-2 md:w-1/4 w-1/2" v-for="brand in brands" :key="brand.id">
                        <div class="border-2 border-gray-200 border-opacity-60 flex justify-center rounded-lg overflow-hidden">
                            <Link :href="route('dashboard.brands.edit', brand)">
                                <img class="h-[80px] object-cover object-center"
                                :src="brand.image"
                                @error="handleErrorImage"/>
                            </Link>
                        </div>
                        <h2 class='uppercase text-center mt-2 mb-2 text-sm font-bold'>{{ brand.title }}</h2>
                    </div>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>
