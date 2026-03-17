<template>
    <div class="flex flex-col min-h-screen h-full w-64 bg-white shadow-xl relative text-gray-700">
        <div class="flex justify-center items-center border-b border-gray-200 shadow-sm bg-white py-4 h-20">
            <img src="/storage/app/public/Logo.png" alt="Company Logo" class="h-10 w-auto object-contain ">
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <router-link :to="{ name: 'dashboard' }"
                :class="['flex items-center px-4 py-3 rounded-lg transition-all duration-200 group font-medium', MenuActive('dashboard') ? 'bg-OrenDamar text-white shadow-md' : 'hover:bg-orange-50 hover:text-gray-900']">
                <svg class="w-5 h-5 mr-3 transition-colors"
                    :class="MenuActive('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-OrenDamar'"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </router-link>

            <router-link :to="{ name: 'user' }"
                :class="['flex items-center px-4 py-3 rounded-lg transition-all duration-200 group font-medium', MenuActive('user') ? 'bg-OrenDamar text-white shadow-md' : 'hover:bg-orange-50 hover:text-gray-900']">
                <svg class="w-5 h-5 mr-3 transition-colors"
                    :class="MenuActive('user') ? 'text-white' : 'text-gray-400 group-hover:text-OrenDamar'" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                User
            </router-link>


            <router-link :to="{ name: 'employees' }"
                :class="['flex items-center px-4 py-3 rounded-lg transition-all duration-200 group font-medium', MenuActive('employees') ? 'bg-OrenDamar text-white shadow-md' : 'hover:bg-orange-50 hover:text-gray-900']">
                <svg class="w-5 h-5 mr-3 transition-colors"
                    :class="MenuActive('employees') ? 'text-white' : 'text-gray-400 group-hover:text-OrenDamar'"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Pegawai
            </router-link>

        </nav>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const isPackagesOpen = ref(false);

const packagesChildren = ['packages', 'food', 'drink', 'additional'];

const isChildOfPackagesActive = computed(() => {
    return packagesChildren.includes(route.name);
});

function togglePackages() {
    isPackagesOpen.value = !isPackagesOpen.value;
}



watch(() => route.name, (newName) => {
    if (packagesChildren.includes(newName)) {
        isPackagesOpen.value = true;
    }
}, { immediate: true });

function MenuActive(routeName) {
    return route.name === routeName;
}
</script>