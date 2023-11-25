<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link} from "@inertiajs/vue3";

let props = defineProps({
    packages:{
        type: Object
    }
})

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Paquetes</h2>
        </template>

        <div class="overflow-auto m-5 mx-auto">
            <div class="flex flex-row justify-end">
                <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2 ml-2"
                      :href="route('dashboard.packages.create')">
                    <div class="flex flex-row gap-4">
                        <img src="/assets/img/add_icon.svg" alt="">
                        <span class="uppercase">Añadir paquete</span>
                    </div>
                </Link>
            </div>

            <table class="w-full text-sm text-gray-800 table-auto font-bold mt-2">
                <thead class="text-left uppercase">
                    <tr>
                        <th scope="col" class="py-4 text-gray-900">
                            #
                        </th>
                        <th scope="col" class="py-4 text-gray-900">
                            Nombre
                        </th>

                        <th scope="col" class="py-4 text-gray-900">
                            Opciones
                        </th>
                    </tr>
                </thead>


                <tbody class="divide-y-8 divide-gray-100 border-gray-100">
                    <tr v-for="packag in packages" :key="packag.id" class="bg-white" style="border-radius: 10px;">
                        <td>
                            <div class="text-sm py-4">
                                <div class="font-medium text-gray-700">
                                    {{ packag.id }}
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="text-sm py-4">
                                <div class="font-medium text-gray-700">
                                    {{ packag.name }}
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="flex gap-4">
                                <Link :href="route('dashboard.package.brands.create', packag.id)" class="bg-black text-white rounded-3xl px-3 py-2">
                                    Ver detalles
                                </Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
