<style lang="scss">
path {
    cursor: pointer;
    transition: all 0.2s ease-in-out;

    &:hover {
        fill: #FFC000;
    }
}
</style>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import states from '/public/assets/json/estados-mexico.json';
import { SVG } from '@svgdotjs/svg.js';
import { ref } from 'vue';
import { onMounted } from 'vue';
import { easepick } from '@easepick/bundle'
import { RangePlugin } from '@easepick/range-plugin';
import Pagination from '@/Components/Pagination.vue'
import axios from 'axios';
import {exportReport} from "@/Services/ReportsService";
import {setDefaultImageBrand} from "@/Services/FileService";

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';

const handleErrorImage = (e) => setDefaultImageBrand(e)

let props = defineProps({
    brands: Object,
    usersList: Object,
    baseUrl: String,
    medium: Object
});

let statesList = ref([]);
let selectedDate = ref()
let dateIsSelected = ref()
let dateStart = ""
let dateEnd = ""
let report = ref([])
let term = ""
let checkedBrands = [];
let token = document.head.querySelector('meta[name="csrf-token"]');
let availability = [];
let showAlert = ref(false);
let typeAlert = ref('');
let msgAlert = ref('');
let showTable = false;
let checkedReport = ref(false)
let checkedStates = [];
let isLoading = ref(false);

onMounted(() => {
    generateMap();
    createDatePicker()
});

const createDatePicker = () => {
    const picker = new easepick.create({
        element: document.getElementById('datepicker'),
        css: [
            'https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.css',
            'https://cdn.jsdelivr.net/npm/@easepick/range-plugin@1.2.1/dist/index.css',
        ],
        inline: true,
        autoApply: true,
        lang: 'es-MX',
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

let id = ref('mexico-map');
let mapAttr = {
    viewBoxWidth: 1000,
    viewBoxHeight: 450,
};

const checkBrand = () => {

    if (checkedBrands.length === 0) {

        typeAlert.value = '';
        msgAlert.value = '';
        showAlert.value = false;

        statesList.value = [];
        availability = [];

        SVG('#map').clear();
        generateMap();

        return;
    }

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

        isLoading.value = true;

        axios.post(props.baseUrl + '/dashboard/mediums/3', {
            brands_id: checkedBrands,
        })
        .then((response) => {
            availability = [];
            statesList.value = [];
            if (typeof response.data.data !== undefined) {
                let arrayOfState = response.data.data
                arrayOfState.forEach(state => {
                    const previuslyState = statesList.value.filter(stateInArray => stateInArray.id === state.id);
                    if (previuslyState.length === 0) {
                        statesList.value.push({
                            id: state.id,
                            name: state.name,
                            selected: false
                        })

                        availability.push({
                            id: state.id,
                            availability: true
                        })
                    }
                });
                showAlert.value = false;
                SVG('#map').clear();
                generateMap();
                isLoading.value = false;
            }
        })
        .catch((error) => {});
    }
};

const generateMap = () => {
    const svgContainer = SVG().addTo('#map').id(id.value).size('100%', '100%').viewbox(0, 0, mapAttr.viewBoxWidth, mapAttr.viewBoxHeight);
    states.forEach((pathObj) => {
        generatePath(svgContainer, pathObj);
    });
};

const generatePath = (svgCont, pathObj) => {
    let states = availability;
    let fillValue = '#bababa80'
    if (states !== null) {
        let selectedState = states.filter((state) => state.id === Number(pathObj['@id']))
        if (selectedState.length) {
            let availability = selectedState[0].availability
            if (availability) {
                fillValue = availability ? "#FFC00080" : "#bababa80"
            }
        }
    }

    const attrs = {
        fill: fillValue,
        stroke: '#F1F5F9',
        'stroke-width': 1,
        title: pathObj['@name'],
        'map-id': pathObj['@id'],
    };

    const province = svgCont.path(pathObj['@d']).attr(attrs);

    province.click((e) => {
        const mapId = e.target.attributes['map-id'].value;
        const title = e.target.attributes.title.value;
        selectState(mapId, title);
    });
};

const handleExportReport = () => {
    let data = {
        states_id: checkedStates,
        brands_id: checkedBrands
    };

    if (dateStart !== '' && dateEnd !== '') {
        data.date_start = `${dateStart.getFullYear()}-${('0' + (dateStart.getMonth() + 1)).slice(-2)}-${('0' + (dateStart.getDate())).slice(-2)}`;
        data.date_end = `${dateEnd.getFullYear()}-${('0' + (dateEnd.getMonth() + 1)).slice(-2)}-${('0' + (dateEnd.getDate())).slice(-2)}`;
    }

    exportReport(props.medium.id, data)
}

const sendReport = () => {

    if (checkedBrands.length === 0) {
        typeAlert.value = 'warning';
        msgAlert.value = '<span>Seleccione al menos una marca para generar el reporte</span>';
        showAlert.value = true;
        return;
    }

    if (checkedStates.length === 0) {
        typeAlert.value = 'warning';
        msgAlert.value = '<span>Seleccione al menos un estado para generar el reporte</span>';
        showAlert.value = true;
        return;
    }

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

        let data = {
            states_id: checkedStates,
            brands_id: checkedBrands
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

                    showTable = report.value.length > 0;
                    checkedReport.value = true
                }
            })
            .catch((error) => {});
    }
}

const search = () => {
    console.log(term);
}

const selectState = (mapId, title) => {
    let isValidstate = validateBrandsAndStates(Number(mapId));
    if (!isValidstate) {
        return;
    }

    for (let i = 0; i < statesList.value.length; i++) {
        if (statesList.value[i].id === Number(mapId)) {
            statesList.value[i].selected = !statesList.value[i].selected;
            if (statesList.value[i].selected === true) {
                checkedStates.push(Number(mapId));
            } else {
                checkedStates = checkedStates.filter(state => state !== Number(mapId));
            }
        }
    }
};

const validateBrandsAndStates = (stateId) => {
    let stateSelected = statesList.value.filter(state => state.id === stateId);

    if (stateSelected.length === 0) {
        typeAlert.value = 'danger';
        msgAlert.value = '<span>Este estado <b>no cuenta con marcas asociadas</b>. Selecciona una marca diferente en la parte superiror.</span>';
        showAlert.value = true;
        return false;
    }

    if (stateSelected.length < statesList.value.length) {
        typeAlert.value = 'warning';
        msgAlert.value = '<span>Las marcas seleccionadas <b>no están disponibles</b> en todas las regiones.</span>';
        showAlert.value = true;
        return true;
    }

    typeAlert.value = '';
    msgAlert.value = '';
    showAlert.value = false;
    return true;
};

const selectStateByLabel = (stateId) => {
    selectState(stateId, '');
}

</script>

<template>
    <Head title="Marcas" />
    <AuthenticatedLayout>
        <section class="text-gray-600 body-font">
            <div class="p-4 mx-auto rounded-sm shadow-md">
                <div v-show="!showTable">
                    <div class="flex flex-row justify-between items-center">
                        <p class="text-lg font-bold text-black border-s-4 border-s-gray-300 ps-2">Selección de marca</p>
                        <button class="bg-gray-400 px-4 py-2 rounded-md text-white uppercase flex flex-row gap-x-1 text-sm">
                            <img src="/assets/img/file-report-outline.svg" alt="" />
                            <span>Reporte detallado</span>
                        </button>
                    </div>
                    <div class="flex lg:flex-row w-full flex-col">
                        <div v-if="brands.length" class="grid grid-cols-4 mt-2 lg:w-8/12 w-full">
                            <div class="p-2" v-for="brand in brands" :key="brand.id">
                                <div class="border-2 border-gray-200 border-opacity-60 rounded-lg relative flex justify-center overflow-hidden">
                                    <form class="absolute left-0">
                                        <input type="checkbox" class="ml-2" v-model="checkedBrands" :value="brand.id"
                                            :id="brand.id" v-on:change="checkBrand" :disabled="isLoading"/>
                                    </form>
                                    <img class="h-[80px]"
                                         @error="handleErrorImage"
                                        :src="brand.fullImagePath" :alt="'Marca-' + brand.name" />
                                </div>
                                <h2 class="uppercase text-center text-sm font-bold my-2">{{ brand.title }}</h2>
                            </div>
                        </div>

                        <div v-else class="flex flex-row w-full items-center justify-center p-4">
                            <p class="text-gray-700 text-xl italic font-semibold">No tienes marcas contratadas</p>
                        </div>

                        <div class="lg:mx-4 lg:mt-8 mt-2 flex flex-row items-center lg:w-4/12 w-full">
                            <button class="rounded-lg uppercase px-4 py-2 bg-[#FFC000]">
                                <Link :href="route('dashboard.packages.index')" class="flex flex-row gap-2 items-center">
                                    <img src="/assets/img/add_icon-black.svg" alt="" />
                                    <span class="font-bold text-base">Contratar más servicios</span>
                                </Link>
                            </button>
                        </div>
                    </div>
                    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-200">
                    <div class="mt-4">
                        <h1 class="font-bold text-lg text-black border-s-4 border-s-gray-300 ps-2 mb-4">Selección de estados de la República</h1>
                    </div>
                    <div class="p-2 rounded mt-4 mb-4 md:w-1/2 w-full text-black text-xs" v-if="showAlert"
                        :class="{ 'bg-yellow-300': typeAlert === 'warning', 'bg-red-600': typeAlert === 'danger' }">
                        <div v-html="msgAlert"></div>
                    </div>
                    <div class="flex lg:flex-row" v-show="statesList.length">

                        <div id="map" class="w-10/12"></div>
                        <div class="flex flex-col">
                            <p class="my-3 font-bold text-lg text-black">Disponibilidad</p>
                            <div class="rounded-md shadow-md bg-white px-4 py-2">
                                <p class="font-semibold text-black cursor-pointer"
                                    v-bind:class="{'text-black' : !state.selected, 'text-yellow-400' : state.selected}"
                                    v-for="state in statesList" v-bind:key="state.id"
                                    @click="() => selectStateByLabel(state.id)">
                                    {{ state.name }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-200">
                    <div class="my-4 w-1/4">
                        <p class="text-lg font-bold text-black mb-4 border-s-4 border-s-gray-300 ps-2 items-center">Selección de periodo</p>
                        <input v-model="selectedDate" id="datepicker" placeholder="Seleccionar periodo" class="w-full pb-2 hidden" />
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
                        <!-- <div class="p-5 flex justify-end">
                            <inertia-link :href="usersList.next_page_url">Siguiente</inertia-link>
                            <inertia-link :href="usersList.prev_page_url">Anterior</inertia-link>
                        </div> -->
                        <pagination class="mt-6" :links="usersList.links" />
                    </div>
                </div>

                <div v-else-if="checkedReport && !report.length" class="w-full flex-row flex justify-center p-4">
                    <p class="text-2xl text-black italic">No hay registros en el reporte</p>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
