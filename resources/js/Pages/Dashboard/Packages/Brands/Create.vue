<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
import Multiselect from '@vueform/multiselect';
import {computed} from "vue";
import ShowPackageInfo from "@/Pages/Dashboard/Reports/ShowPackageInfo.vue";

let props = defineProps({
    packageBrands: {
        type: Object
    },
    package: {
        typ: Object
    },
    brands: {
        type: Object
    },
    states: {
        type: Object
    },
    origins: {
        type: Object
    },
    mediums: {
        type: Object
    }
})

const form = useForm({
    brand_id : null,
    state_ids: null,
    magazine_ids: null,
    newsPapers_ids: null,
    stations_ids: null,
    tvChannels_ids: null,
    isSelectedOOH: null,
    isSelectedRevista: null,
    isSelectedPrensa: null,
    isSelectedRadio: null,
    isSelectedTV: null
})

const optionsStates     = [];
const optionsMagazines  = [];
const optionsNewsPapers = [];
const optionsStations   = [];
const optionsTvChannels = [];

const fillMediums = {
    'OOH' : {
        origin: props.states,
        destiny: optionsStates
    },
    'REVISTA' : {
        origin : props.origins['REVISTA'],
        destiny: optionsMagazines
    },
    'PRENSA' : {
        origin: props.origins['PRENSA'],
        destiny: optionsNewsPapers
    },
    'RADIO' : {
        origin: props.origins['RADIO'],
        destiny: optionsStations
    },
    'TELEVISION' : {
        origin: props.origins['TELEVISION'],
        destiny: optionsTvChannels
    }
}

props.mediums.some((medium) => {
    const source = fillMediums[medium.name]
    const arrayOfItemsInMediums = source.origin
    arrayOfItemsInMediums.map((medium) => {
        source.destiny.push({value: medium.id, label: medium.name })
    })
})

const sendForm = () => {
    form.post(route('dashboard.package.brands.store', props.package.id), {
        onFinish: () => location.reload()
    })
}

const validateOOHCheckboxMessage = computed(() => {

    if (form.isSelectedOOH && !optionsStates.length) {
        return "No se encuentra ningún estado disponible"
    }

    if (form.isSelectedOOH && (!form.data().state_ids || !form.data().state_ids.length)) {
        return "Selecciona por lo menos un estado"
    }
})
const validateRevistaCheckboxMessage = computed(() => {
    if (form.isSelectedRevista && !optionsMagazines.length) {
        return "No se encuentra ninguna revista disponible"
    }

    if (form.isSelectedRevista && (!form.data().magazine_ids || !form.data().magazine_ids.length)) {
        return "Selecciona por lo menos una revista"
    }
})
const validatePrensaCheckbox = computed(() => {
    if (form.isSelectedPrensa && !optionsNewsPapers.length) {
        return "No se encuentra ninguna revista disponible"
    }

    if (form.isSelectedPrensa && (!form.data().newsPapers_ids || !form.data().newsPapers_ids.length)) {
        return "Selecciona por lo menos una revista"
    }

})
const validateRadioCheckbox = computed(() => {
    if (form.isSelectedRadio && !optionsStations.length) {
        return "No se encuentra ninguna estación de radio disponible"
    }

    if (form.isSelectedRadio && (!form.data().stations_ids || !form.data().stations_ids.length)) {
        return "Selecciona por lo menos una estación de radio"
    }
})
const validateTvCheckboxMessage = computed(() => {

    if (form.isSelectedTV && !optionsTvChannels.length) {
        return "No se encuentra ningún grupo de canales disponible"
    }

    if (form.isSelectedTV && (!form.data().tvChannels_ids || !form.data().tvChannels_ids.length)) {
        return "Selecciona por lo menos un grupo de canales"
    }
})

</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>
    <AuthenticatedLayout>

        <div class="flex flex-col w-full p-4">
            <h2 class="font-semibold text-xl leading-tight my-5">Registro de paquetes</h2>
            <p class="text-gray-600">
                Ingresa todos los datos necesarios de tu nuevo paquete para
                garantizar el acceso a los canales específicos de cada medio,
                permitiendo a los usuarios acceder a dichos informes.
            </p>

            <div class="flex flex-row justify-between mt-5">
                <div class="flex flex-col gap-2 w-1/3">
                    <p class="text-black text-xl font-semibold">Marca</p>
                    <select v-model="form.brand_id" class="text-black mt-1 items-center flex bg-white border-gray-300 rounded-md">
                        <option class="text-black" selected="selected">Selecciona tu marca</option>
                        <option class="text-gray-700" v-for="(index, brand) in brands" v-bind:id="brand.id" :value="index">{{brand}}</option>
                    </select>
                </div>
            </div>

            <form @submit.prevent="sendForm">
                <div class="grid grid-cols-3 mt-8 gap-5">
                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-row items-center gap-1">
                            <input class="rounded-md" type="checkbox" v-model="form.isSelectedOOH">
                            <label class="text-black font-bold uppercase">OOH</label>
                        </div>
                        <Multiselect :disabled="!form.isSelectedOOH" noOptionsText="Lista vacía" v-model="form.state_ids" :taggable="true" :options="optionsStates" searchable mode="tags" placeholder="Selecciona tu(s) estados"/>
                        <label v-if="validateOOHCheckboxMessage" class="text-yellow-500 font-bold">{{validateOOHCheckboxMessage}}</label>
                        <label class="text-gray-600">Selecciona tu(s) estados</label>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-row items-center gap-1">
                            <input class="rounded-md" type="checkbox" v-model="form.isSelectedRevista">
                            <label class="text-black font-bold uppercase">Revista</label>
                        </div>
                        <Multiselect :disabled="!form.isSelectedRevista" noOptionsText="Lista vacía" v-model="form.magazine_ids" :taggable="true" :options="optionsMagazines" searchable mode="tags" placeholder="Selecciona tu(s) revistas"/>
                        <label v-if="validateRevistaCheckboxMessage" class="text-yellow-500 font-bold">{{validateRevistaCheckboxMessage}}</label>
                        <label class="text-gray-600">Selecciona tu(s) revistas</label>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-row items-center gap-1">
                            <input class="rounded-md" type="checkbox" v-model="form.isSelectedPrensa">
                            <label class="text-black font-bold uppercase">Prensa</label>
                        </div>
                        <Multiselect :disabled="!form.isSelectedPrensa" noOptionsText="Lista vacía" v-model="form.newsPapers_ids" :taggable="true" :options="optionsNewsPapers" searchable mode="tags" placeholder="Selecciona tu(s) periódicos"/>
                        <label v-if="validatePrensaCheckbox" class="text-yellow-500 font-bold">Selecciona por lo menos un periódico</label>
                        <label class="text-gray-600">Selecciona tu(s) periódicos</label>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-row items-center gap-1">
                            <input class="rounded-md" type="checkbox" v-model="form.isSelectedRadio">
                            <label class="text-black font-bold uppercase">Radio</label>
                        </div>
                        <Multiselect :disabled="!form.isSelectedRadio" noOptionsText="Lista vacía" v-model="form.stations_ids" :taggable="true" :options="optionsStations" searchable mode="tags" placeholder="Selecciona tu(s) estaciones de radio"/>
                        <label v-if="validateRadioCheckbox" class="text-yellow-500 font-bold">Selecciona por lo menos una estación de radio</label>
                        <label class="text-gray-600">Selecciona tu(s) estaciones de radio</label>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-row items-center gap-1">
                            <input class="rounded-md" type="checkbox" v-model="form.isSelectedTV">
                            <label class="text-black font-bold uppercase">Televisión</label>
                        </div>
                        <Multiselect :disabled="!form.isSelectedTV" noOptionsText="Lista vacía" v-model="form.tvChannels_ids" :taggable="true" :options="optionsTvChannels" searchable mode="tags" placeholder="Selecciona tu(s) canales"/>
                        <label v-if="validateTvCheckboxMessage" class="text-yellow-500 font-bold">{{validateTvCheckboxMessage}}</label>
                        <label class="text-gray-600">Selecciona tu(s) canales</label>
                    </div>
                </div>

                <button type="submit" class="py-2 my-7 px-4 bg-yellow-500 text-black rounded-xl">
                    <div class="flex flex-row gap-3 items-center">
                        <img src="/assets/img/carbon-save.svg" alt="" width="26">
                        <span class="uppercase text-sm font-bold">Guardar</span>
                    </div>
                </button>
            </form>

            <ShowPackageInfo :package-brands="packageBrands"></ShowPackageInfo>
        </div>

    </AuthenticatedLayout>
</template>
