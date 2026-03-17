<template>
    <header class="h-20 w-full bg-white border-b border-gray-200 shadow-sm shadow-sm px-8">
        <div class="flex justify-between items-center h-full gap-4">
            <div class="flex items-center gap-4">
                <button @click="$emit('toggle-sidebar')" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <div class="hidden sm:block">
                    <h2 class="text-sm font-medium text-gray-400 leading-none mb-1">Selamat Datang kembali,</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ currentDate }}</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 border-r border-gray-200 pr-6">

                    <div class="text-right hidden sm:block">
                        <h1 class="text-sm font-bold text-gray-800 leading-none mb-1">{{ user || 'Admin' }}</h1>
                    </div>

                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold shadow-sm ring-2 ring-white">
                        {{ user ? user.charAt(0).toUpperCase() : 'A' }}
                    </div>
                </div>

                <button @click="logout"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200 group">
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    Logout
                </button>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const emit = defineEmits(['toggle-sidebar']);
const user = ref(localStorage.getItem('user'));

const currentDate = new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
});

function logout() {
    localStorage.removeItem('token');
    router.push({ name: 'login' });
}

function goToBooking() {
    router.push({ name: 'booking' });
}

function goToDashboard() {
    router.push({ name: 'dashboard' });
}
</script>

<style scoped>
header {
    -webkit-font-smoothing: antialiased;
}
</style>