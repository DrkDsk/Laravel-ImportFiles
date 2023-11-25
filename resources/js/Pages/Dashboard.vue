<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import {setDefaultImageBrand} from "@/Services/FileService";

const props = defineProps({
    brands: Object,
});

const showModalAddService = ref(false);
const showServices = ref(false);

const openModalAddService = () => {
    showModalAddService.value = !showModalAddService.value;
};

const showServicesOfSelectedBrand = () => {
    showServices.value = true;
};

const handleErrorImage = (e) => setDefaultImageBrand(e)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex flex-col mt-12">
            <div class="flex flex-grow">
                <div class="flex">
                    <div
                        class="rounded-3xl inline-block w-80 overflow-hidden shadow-xl transition ease-in-out hover:-translate-y-1 hover:scale-102 duration-300"
                    >
                        <div class="relative group w-full overflow-hidden h-12 rounded-t-3xl bg-black">
                            <div class="absolute bg-gradient-to-t from-black w-full h-full flex items-end justify-center -inset-y-0">
                                <h1 class="font-bold text-2xl text-white mb-2">Bienvenido {{ $page.props.auth.user.name }}</h1>
                            </div>
                        </div>
                        <div class="bg-white flex flex-col">
                            <div class="px-3 pb-6 pt-2">
                                <p class="mt-2 font-sans font-extrabold text-2xl">Tu información:</p>
                                <div class="mr-3 mt-3">
                                    <p class="text-xl font-semibold" style="color: #171717">Próxima facturación:</p>
                                    <span>25/02/2023</span>
                                </div>
                                <div class="mr-3 my-2">
                                    <p class="text-xl font-semibold" style="color: #171717">Modalidad de pago:</p>
                                    <span>Mensual</span>
                                </div>
                                <div class="mr-3 my-2">
                                    <p class="text-xl font-semibold" style="color: #171717">Soporte:</p>
                                    <span>soporte@mediacorpgroup.net</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex mx-4 w-full">
                    <div class="bg-white flex flex-col rounded-3xl w-full shadow-xl">
                        <div class="p-8">
                            <p class="mt-2 font-sans font-extrabold text-2xl">Marcas contratadas</p>
                            <p class="mt-2 font-sans text-xl text-slate-500">Selecciona la marca que quieres revisar</p>
                        </div>
                        <div class="mb-6 grid grid-cols-4 px-8 gap-x-5 gap-y-10">
                            <div v-if="brands.length === 0" class="bg-orange-400 p-2 rounded text-white font-bold">No hay Marcas asignadas.</div>
                            <div v-for="brand in brands" v-on:click="showServicesOfSelectedBrand">
                                <div class="cursor-pointer shadow-md p-4 flex justify-center rounded-lg hover:scale-110 transition duration-300">
                                    <img class="h-[80px]" :src="'storage/' + brand.image"  @error="handleErrorImage" alt="" />
                                </div>
                                <h1 class="mt-4 font-bold text-center text-sm uppercase">{{ brand.name }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showServices">
            <div class="flex flex-row mt-12">
                <div class="flex flex-row justify-between w-full mx-4">
                    <p class="text-xl font-bold">Servicios contratados</p>
                    <button v-on:click="openModalAddService" class="px-4 py-2 bg-black text-white rounded-3xl flex flex-row gap-2">
                        <img src="/assets/img/add_icon.svg" alt="" />
                        <span>Añadir Servicio</span>
                    </button>
                </div>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 tracking-wider">Revista</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 tracking-wider">OOH</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 tracking-wider">Televisión</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 tracking-wider">Radio</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 tracking-wider">Prensa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-8 divide-gray-100 border-gray-100">
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">1.- Consumidor</p>
                                </td>

                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">1.- Ciudad de México</p>
                                </td>

                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">1.- Bandamax</p>
                                </td>

                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap italic">Ningún servicio añadido</p>
                                </td>

                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap italic">Ningún servicio añadido</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">2.- cosas</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">2.- méxico</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">2.- telehit</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">3.- Q</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">3.- Jalisco</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">3.- MRS</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div
                v-if="showModalAddService"
                class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
            >
                <div>
                    <div class="rounded-3xl shadow-lg shadow-gray-800 bg-white" style="width: 550px">
                        <div class="p-2 place-content-center">
                            <div class="flex flex-row justify-end">
                                <button v-on:click="openModalAddService">
                                    <span><img src="/assets/img/carbon_close-outline.svg" class="w-10" alt="" /></span>
                                </button>
                            </div>
                            <div class="flex flex-col items-center">
                                <p class="text-center my-4 px-5 font-semibold text-blueGray-500 text-2xl">
                                    <img class="mx-auto" src="/assets/img/brands/img_brand.png" alt="" />
                                </p>

                                <p class="text-center my-4 px-5 font-bold text-blueGray-500 text-3xl">Selección de Servicio</p>

                                <select class="text-start w-6/12 my-8 rounded-lg border-[#A1AFC2]" name="service_id" id="service">
                                    <option value="">Seleccionar servicio</option>
                                    <option value="1">Revista</option>
                                    <option value="2">OOH</option>
                                    <option value="3">Televisón</option>
                                    <option value="4">Radio</option>
                                    <option value="5">Prensa</option>
                                </select>
                            </div>
                            <p class="text-center">
                                <button
                                    class="text-center text-white rounded-lg bg-slate-800 uppercase px-6 py-2 text-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="button"
                                >
                                    Ok
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
