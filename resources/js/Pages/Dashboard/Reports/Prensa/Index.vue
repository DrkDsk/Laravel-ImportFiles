<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { easepick } from '@easepick/bundle'
import { onMounted } from 'vue';
import { RangePlugin } from '@easepick/range-plugin';
import { exportReport } from '@/Services/ReportsService';
import {setDefaultImageBrand} from "@/Services/FileService";

onMounted(() => {
    crateDatePicker()
})

const handleErrorImage = (e) => setDefaultImageBrand(e)

const crateDatePicker = () => {
    const picker = new easepick.create({
        element: document.getElementById('datepicker'),
        css: [
            'https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.css',
            'https://cdn.jsdelivr.net/npm/@easepick/range-plugin@1.2.1/dist/index.css',
        ],
        inline : true,
        autoApply : true,
        plugins: [RangePlugin],
    })

    picker.on('select', (e) => {
        const details = e.detail
        if (details.start && details.end) {
            dateStart = details.start
            dateEnd = details.end
            dateIsSelected.value = true
        }
    })
}

const props = defineProps({
    brands: Object,
    medium: Object,
    baseUrl: String
})

let report = ref([])
let checkedBrands = ref([])
let checkedPrensas = ref([])
let selectedDate = ref()
let term = ""
let dateStart = ""
let dateEnd = ""
let dateIsSelected = ref()
let prensas = ref([])
let token = document.head.querySelector('meta[name="csrf-token"]');
let isLoading = ref(false);
let showAlert = ref(false);
let typeAlert = ref('');
let msgAlert = ref('');
let showTable = ref(false);
let checkedReport = ref(false)

const form = useForm({
    brands_id : null,
})

const checkBrand = () => {
    let arrayBrandsId = checkedBrands.value.map(brand => brand)
    form.brands_id = arrayBrandsId
    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        prensas.value = [];

        axios.post(props.baseUrl + '/dashboard/mediums/' + props.medium.id, {
            brands_id: arrayBrandsId
        })
        .then((response) => {
            if (typeof response.data.data !== undefined) {
                response.data.data.forEach(origin => {
                    const previuslyOrigin = prensas.value.filter(originInArray => originInArray.id === origin.id)
                    if (!previuslyOrigin.length) {
                        prensas.value.push({
                            id: origin.id,
                            name: origin.name,
                            image: origin.fullImagePath ?? props.baseUrl + '/img/base_brand.jpg'
                        });
                    }
                });
            }
        })
    }
}

const checkMagazine = (magazine_id) => {
    if (checkedPrensas.length < prensas.value.length) {
        typeAlert.value = 'warning';
        msgAlert.value = '<span>Las marcas seleccionadas <b>no están disponibles</b> en todas las prensas.</span>';
        showAlert.value = true;
        return;
    }
}

const handleExportReport = () => {
    let data = {
        origins_id: checkedPrensas.value,
        brands_id: checkedBrands.value
    };

    if (dateStart !== '' && dateEnd !== '') {
        data.date_start = `${dateStart.getFullYear()}-${('0' + (dateStart.getMonth() + 1)).slice(-2)}-${('0' + (dateStart.getDate())).slice(-2)}`;
        data.date_end = `${dateEnd.getFullYear()}-${('0' + (dateEnd.getMonth() + 1)).slice(-2)}-${('0' + (dateEnd.getDate())).slice(-2)}`;
    }

    exportReport(props.medium.id, data)
}

const sendReport = () => {
    if (checkedBrands.value.length === 0) {
        typeAlert.value = 'warning';
        msgAlert.value = '<span>Seleccione al menos una marca para generar el reporte</span>';
        showAlert.value = true;
        return;
    }

    if (checkedPrensas.length === 0) {
        typeAlert.value = 'warning';
        msgAlert.value = '<span>Seleccione al menos una revista para generar el reporte</span>';
        showAlert.value = true;
        return;
    }

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

        let data = {
            origins_id: checkedPrensas.value,
            brands_id: checkedBrands.value
        };

        if (dateStart !== '' && dateEnd !== '') {
            data.date_start = `${dateStart.getFullYear()}-${('0' + (dateStart.getMonth() + 1)).slice(-2)}-${('0' + (dateStart.getDate())).slice(-2)}`;
            data.date_end = `${dateEnd.getFullYear()}-${('0' + (dateEnd.getMonth() + 1)).slice(-2)}-${('0' + (dateEnd.getDate())).slice(-2)}`;
        }

        axios.post(props.baseUrl + '/api/reports/' + props.medium.id, data)
            .then((response) => {
                if (response.status === 200 && response.statusText === "OK") {
                    response.data.data.forEach(row => {
                        report.value.push({
                            id: row.id,
                            type: row.insertion.name,
                            view: row.vista_posicion,
                            state: row.state.name,
                            title: row.origin.name,
                            brand: row.brand.name,
                            product: row.product.name,
                            version: row.version,
                            month: row.mes
                        });
                    });

                    showTable.value = report.value.length > 0;
                    checkedReport.value = true
                }
            })
            .catch((error) => {});
    }
}

</script>

<template>
    <Head title="Marcas" />
    <AuthenticatedLayout>
        <section class="text-gray-600 body-font">
            <div class="p-4 mx-auto bg-white rounded-sm shadow-md">
                <div v-show="!showTable">
                    <div class="flex flex-row justify-between">
                        <p class="text-lg font-bold text-black">Selección de marca</p>
                        <button class="bg-gray-400 px-4 py-2 rounded-md text-white uppercase flex flex-row gap-x-1 text-sm">
                            <img src="/assets/img/file-report-outline.svg" alt="">
                            <span>Reporte detallado</span>
                        </button>
                    </div>
                    <div class="flex lg:flex-row w-full flex-col">
                        <div v-if="brands.length" class="grid grid-cols-4 mt-2 lg:w-8/12 w-full">
                            <div class="p-2" v-for="brand in brands" :key="brand.id">
                                <h2 class="uppercase text-sm font-bold my-2">{{ brand.name }}</h2>
                                <div class="border-2 border-gray-200 border-opacity-60 rounded-lg relative flex justify-center overflow-hidden">
                                    <form class="absolute left-0">
                                        <input type="checkbox" class="ml-2" v-model="checkedBrands" :value="brand.id"
                                            :id="brand.id" v-on:change="checkBrand" :disabled="isLoading"/>
                                    </form>
                                    <img class="h-[80px]"
                                         @error="handleErrorImage"
                                        :src="brand.fullImagePath" :alt="'Marca-' + brand.name" />
                                </div>
                            </div>
                        </div>

                        <div v-else class="flex flex-row w-full items-center justify-center p-4">
                            <p class="text-gray-700 text-xl italic font-semibold">No tienes marcas contratadas</p>
                        </div>

                        <div class="lg:mx-4 lg:mt-8 mt-2 flex flex-row items-center lg:w-4/12 w-full">
                            <button class="rounded-lg uppercase px-4 py-2 bg-[#FFC000]">
                                <Link :href="route('dashboard.packages.index')" class="flex flex-row gap-2 items-center">
                                    <img src="/assets/img/add_icon-black.svg" alt="">
                                    <span class="font-bold text-base">Contratar más servicios</span>
                                </Link>
                            </button>
                        </div>
                    </div>
                    <div class="my-4">
                        <p class="text-lg font-bold text-black">Selección de revistas</p>
                        <div class="grid grid-cols-4 mt-2 lg:w-8/12 w-full">
                            <div class="p-2" v-for="prensa in prensas" :key="prensa.id">
                                <div class="border-2 border-gray-200 border-opacity-60 rounded-lg relative flex justify-center overflow-hidden">
                                    <form class="absolute left-0">
                                        <input type="checkbox" class="ml-2" v-model="checkedPrensas" :value="prensa.id"
                                            v-on:change="() => checkMagazine(prensa.id)">
                                    </form>
                                    <img @error="handleErrorImage" class="h-[80px]" :src="prensa.image" alt="Marca" />
                                </div>
                                <p>{{ prensa.name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="my-4 w-1/4">
                        <p class="text-lg font-bold text-black mb-2">Selección de periodo</p>
                        <input v-model="selectedDate" id="datepicker" placeholder="Seleccionar periodo" class="w-full pb-2"/>
                    </div>
                    <div class="my-4 w-1/4">
                        <button v-on:click="sendReport" type="button"
                            class="rounded-md bg-black text-white p-4 font-semibold flex flex-row gap-2">
                            <span>
                                <img src="/assets/img/file-report-outline.svg" alt="">
                            </span>
                            CREAR REPORTE
                        </button>
                    </div>
                </div>
                <div v-if="showTable">
                    <div class="flex flex-row-reverse justify-between">
                        <input type="text" id="search" v-model="term" @keyup="search" class="w-1/3 rounded-3xl bg-[#DEE5ED]"
                            placeholder="search">
                    </div>

                    <div class="flex flex-row-reverse justify-between my-4">

                        <div class="flex flex-row gap-2">
                            <button v-on:click="handleExportReport" type="button" class="rounded-md bg-black text-white px-4 py-1">
                                Exportar XLS
                            </button>
                            <button v-on:click="sendReport" type="button" class="rounded-md bg-black text-white px-4 py-1">
                                Exportar PDF
                            </button>
                            <span>
                                <img src="/assets/img/line.svg" alt="">
                            </span>
                            <Link class="rounded-lg uppercase px-4 py-2 bg-[#FFC000]"
                                :href="route('dashboard.medium', medium.id)">
                                <div class="flex flex-row gap-2 items-center">
                                    <img src="/assets/img/new_report.svg" alt="" />
                                    <span class="font-bold text-base">nuevo reporte</span>
                                </div>
                            </Link>
                        </div>
                    </div>

                    <div class="overflow-auto">
                        <table class="w-full text-sm text-gray-800 table-auto font-bold mb-4">
                            <thead class="text-center uppercase">
                                <tr>
                                    <th scope="col" class="py-4 text-gray-900">
                                        Tipo inserción
                                    </th>
                                    <th scope="col" class="py-4 text-gray-900">
                                        Vista/Posición
                                    </th>
                                    <th scope="col" class="text-center py-4 text-gray-900">
                                        Estado
                                    </th>
                                    <th scope="col" class="text-center py-4 text-gray-900">
                                        Avenida/Titulo/Canal/Estación
                                    </th>
                                    <th scope="col" class="text-center py-4 text-gray-900">
                                        Marca
                                    </th>
                                    <th scope="col" class="text-center py-4 text-gray-900">
                                        Producto
                                    </th>
                                    <th scope="col" class="text-center py-4 text-gray-900">
                                        Versión
                                    </th>
                                    <th scope="col" class="text-center py-4 text-gray-900">
                                        Mes
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-8 divide-gray-100 text-center border-gray-100">
                                <tr v-for="element in report" :key="element.id" class="bg-white uppercase"
                                    style="border-radius: 10px;">
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.type }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.view }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.state }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.brand }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.product }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.version }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm py-4 px-4">
                                            <div class="font-medium text-gray-700">
                                                {{ element.month }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-else-if="checkedReport && !report.length" class="w-full flex-row flex justify-center p-4">
                    <p class="text-2xl text-black italic">No hay registros en el reporte</p>
                </div>

            </div>
        </section>
    </AuthenticatedLayout>
</template>
