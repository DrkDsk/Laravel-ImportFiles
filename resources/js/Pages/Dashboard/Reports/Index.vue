<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

let props = defineProps({
    mediumsFilteredCount : Object
});

</script>

<template>
    <Head title="Admin - Reportes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Medios Contratados</h2>
                <button class="uppercase px-5 py-3 bg-black text-white rounded-lg">
                    <div class="flex">
                        <img src="/assets/img/report_icon.svg" alt="">
                        <span class="ml-3">Informe multimedia</span>
                    </div>
                </button>
            </div>
        </template>

        <div class="grid grid-cols-3 gap-y-10">
            <div class="rounded-3xl shadow-lg bg-white w-72">
                <div class="py-4 px-4 flex flex-row justify-between">
                    <img src="/assets/img/OOH.svg" alt="">
                    <div class="flex flex-col items-center text-center">
                        <Link :href="route('dashboard.packages.index')" class="mx-auto" v-if="!mediumsFilteredCount['OOH']">
                            <img src="/assets/img/add_black.svg" alt="" class="ml-4">
                            <span class="text-center">Contratar</span>
                        </Link>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold px-4">OOH</h1>
                <h1 class="text-md px-4 mt-3 mb-4">{{mediumsFilteredCount["OOH"]}} espectaculares</h1>
            </div>

            <div class="rounded-3xl shadow-lg bg-white w-72">
                <div class="py-4 px-4 flex flex-row justify-between">
                    <img src="/assets/img/PRENSA.svg" alt="">
                    <div class="flex flex-col items-center text-center">
                        <Link :href="route('dashboard.packages.index')" class="mx-auto" v-if="!mediumsFilteredCount['PRENSA']">
                            <img src="/assets/img/add_black.svg" alt="" class="ml-4">
                            <span class="text-center">Contratar</span>
                        </Link>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold px-4">Prensa</h1>
                <h1 class="text-md px-4 mt-3 mb-4">{{mediumsFilteredCount["PRENSA"]}} periódicos</h1>
            </div>

            <div class="rounded-3xl shadow-lg bg-white w-72">
                <div class="py-4 px-4 flex flex-row justify-between">
                    <img src="/assets/img/RADIO.svg" alt="">
                    <div class="flex flex-col items-center text-center">
                        <Link :href="route('dashboard.packages.index')" class="mx-auto" v-if="!mediumsFilteredCount['RADIO']">
                            <img src="/assets/img/add_black.svg" alt="" class="ml-4">
                            <span class="text-center">Contratar</span>
                        </Link>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold px-4">Radio</h1>
                <h1 class="text-md px-4 mt-3 mb-4">{{mediumsFilteredCount["RADIO"]}} estaciones</h1>
            </div>

            <div class="rounded-3xl shadow-lg bg-white w-72">
                <div class="py-4 px-4 flex flex-row justify-between">
                    <img src="/assets/img/REVISTA.svg" alt="">
                    <div class="flex flex-col items-center text-center">
                        <Link :href="route('dashboard.packages.index')" class="mx-auto" v-if="!mediumsFilteredCount['REVISTA']">
                            <img src="/assets/img/add_black.svg" alt="" class="ml-4">
                            <span class="text-center">Contratar</span>
                        </Link>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold px-4">Revista</h1>
                <h1 class="text-md px-4 mt-3 mb-4">{{mediumsFilteredCount["REVISTA"]}} revistas</h1>
            </div>

            <div class="rounded-3xl shadow-lg bg-white w-72">
                <div class="py-4 px-4 flex flex-row justify-between">
                    <img src="/assets/img/TV.svg" alt="">
                    <div class="flex flex-col items-center text-center">
                        <Link :href="route('dashboard.packages.index')" class="mx-auto" v-if="!mediumsFilteredCount['TELEVISION']">
                            <img src="/assets/img/add_black.svg" alt="" class="ml-4">
                            <span class="text-center">Contratar</span>
                        </Link>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold px-4">Televisión</h1>
                <h1 class="text-md px-4 mt-3 mb-4">{{mediumsFilteredCount["TELEVISION"]}} canales</h1>
            </div>

        </div>

    </AuthenticatedLayout>
</template>
