<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed } from 'vue';

const props = defineProps({
    servicesCollection: Object,
    category: Object,
});

const servicesCollection = computed(() => props.servicesCollection.data);

function deleteAction(serviceId) {
    router.delete(route('dashboard.services.destroy', serviceId));
}
</script>

<template>
    <Head title="Servicios - Categorías" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Servicios</h2>
        </template>

        <div class="overflow-auto m-5 mx-auto">
            <div class="flex space-x-2 flex-row justify-end">
                <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2" :href="route('dashboard.category.index', category.id)">
                    <span>Regresar</span>
                </Link>
                <Link class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2" :href="route('dashboard.category.services.create', category.id)">
                    <img src="/assets/img/add_icon.svg" alt="" />

                    <span>Agregar</span>
                </Link>
            </div>

            <table class="w-full text-sm text-gray-800 table-auto font-bold">
                <thead class="text-left uppercase">
                    <tr>
                        <th scope="col" class="py-4 text-gray-900">Nombre</th>

                        <th scope="col" class="py-4 text-gray-900">Marca</th>

                        <th scope="col" class="py-4 text-gray-900">Categoría</th>
                        <th scope="col" class="text-center py-4 text-gray-900">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y-8 divide-gray-100 border-gray-100">
                    <tr v-for="service in servicesCollection" class="bg-white" style="border-radius: 10px">
                        <td>
                            <div class="text-sm py-2 px-4">
                                <div class="font-medium text-gray-700">
                                    {{ service.name }}
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="text-sm py-2 px-4">
                                <div class="font-medium text-gray-700">
                                    {{ service.brand.name }}
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="text-sm py-2 px-4">
                                <div class="font-medium text-gray-700">
                                    {{ service.category.name }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-4">
                                <div>
                                    <Link :href="route('dashboard.services.edit', service.id)">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="h-6 w-6"
                                            x-tooltip="tooltip"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                                            />
                                        </svg>
                                    </Link>
                                </div>

                                <div>
                                    <button @click="deleteAction(service.id)">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-6 h-6"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
