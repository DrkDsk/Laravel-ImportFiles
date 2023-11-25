<script setup>

import { checkIfShowStatesOrOrings} from "@/Services/PackageService";
import {ref} from "vue";
import Swal from 'sweetalert2'

let props = defineProps({
    packageBrands: {
        type: Object
    }
})

const modalData = ref([])

const showModal = (originsOrStates, mediumName) => {
    modalData.value = checkIfShowStatesOrOrings(originsOrStates, mediumName)
    const messageList = modalData.value.join('\n ')
    Swal.fire(messageList)
}

const getTitleForOrigins = (medium) => {
    if (medium === "OOH") {
        return "Ver estados"
    }

    return "Ver orígenes"
}

</script>

<template>
    <table v-if="packageBrands.length" class="w-full text-sm text-gray-800 table-auto font-bold mt-2">
        <thead class="text-left uppercase">
        <tr>
            <th scope="col" class="py-4 px-2 text-gray-900 text-center">
                #
            </th>
            <th scope="col" class="py-4 px-2 text-gray-900 text-center">
                Marca
            </th>
            <th scope="col" class="py-4 px-2 text-gray-900 text-center">
                Medio
            </th>
            <th scope="col" class="py-4 px-2 text-gray-900 text-center">
                Opciones
            </th>
        </tr>
        </thead>
        <tbody class="divide-y-8 divide-gray-100 border-gray-100">
        <tr v-for="packageBrand in packageBrands" :key="packageBrand.id" class="bg-white" style="border-radius: 10px;">
            <td>
                <div class="text-sm py-4 px-2 text-center">
                    <div class="font-medium text-gray-700">
                        {{ packageBrand.id }}
                    </div>
                </div>
            </td>

            <td>
                <div class="text-sm py-4 px-2 text-center">
                    <div class="font-medium text-gray-700">
                        {{ packageBrand.brand.name }}
                    </div>
                </div>
            </td>

            <td>
                <div class="text-sm py-4 px-2 text-center">
                    <div class="font-medium text-gray-700">
                        {{ packageBrand.medium.name }}
                    </div>
                </div>
            </td>
            <td>
                <div class="text-sm py-4 px-2 text-center">
                    <button @click="showModal(packageBrand.company_brand_locations, packageBrand.medium.name)" class="font-medium text-sky-700 underline">
                        {{ getTitleForOrigins(packageBrand.medium.name) }}
                    </button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div v-else class="w-full flex flex-row justify-center p-4">
        <p class="italic text-gray-600 font-bold text-2xl">
            Sin marcas registradas
        </p>
    </div>
</template>

<style scoped>

</style>
