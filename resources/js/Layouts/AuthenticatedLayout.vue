<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import SidebarLinks from '@/Components/SidebarLinks.vue';

const isOpen = ref(false);
const activeClass = ref('bg-gray-600 bg-opacity-25 text-gray-100 border-gray-100');
const inactiveClass = ref('border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100');
const dropdownOpen = ref(false);;
</script>

<template>
    <div class="flex h-screen bg-[#000000] font-roboto">
        <div class="flex">
            <!-- Backdrop -->
            <div :class="isOpen ? 'block' : 'hidden'" @click="isOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
            <!-- End Backdrop -->

            <div
                :class="isOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
                class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform  lg:translate-x-0 lg:static lg:inset-0"
            >
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <span class="mx-2 text-2xl font-semibold text-white uppercase"><img :src='"/img/logo_media.png"' alt='Logo'></span>
                    </div>
                </div>

                <nav class="mt-10">
                    <SidebarLinks />
                </nav>
            </div>
        </div>

        <div class='fixed bg-[#FFC000] w-6 h-full rounded-tl-[40px] mt-16 left-60'></div>

        <div class="flex-1 flex flex-col overflow-hidden rounded-tl-[40px] bg-[#F1F5F9] z-40">

            <header class="flex items-center justify-between pt-6 mx-6 border-b">
                <div class="flex items-center">
                    <button @click="isOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="relative mx-4 lg:mx-0">
                        <slot name='header'/>
                    </div>
                </div>

                <div class="flex items-center">
                    <button class="flex mx-4 text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </button>

                    <div class="relative">
                        <button
                            @click="dropdownOpen = !dropdownOpen"
                            class="relative z-10 block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none"
                        >
                            <img
                                class="object-cover w-full h-full"
                                src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=296&q=80"
                                alt="Your avatar"
                            />
                        </button>

                        <div v-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

                        <transition
                            enter-active-class="transition duration-150 ease-out transform"
                            enter-from-class="scale-95 opacity-0"
                            enter-to-class="scale-100 opacity-100"
                            leave-active-class="transition duration-150 ease-in transform"
                            leave-from-class="scale-100 opacity-100"
                            leave-to-class="scale-95 opacity-0"
                        >
                            <div v-show="dropdownOpen" class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl">
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="text-left w-full px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                                >Logout</Link
                                >
                            </div>
                        </transition>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F1F5F9]">
                <div class="container mx-auto pt-5 px-6">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
