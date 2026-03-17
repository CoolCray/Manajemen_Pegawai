<template>
    <div class="h-screen w-full overflow-hidden bg-[#f8fafc] text-gray-900 font-inter">
        <div class="h-full w-full flex overflow-hidden relative" v-if="!['login', 'booking'].includes(router.currentRoute.value.name)">
            
            <!-- Mobile Sidebar Backdrop -->
            <div v-if="sidebarOpen" @click="sidebarOpen = false" 
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 lg:hidden transition-opacity duration-300">
            </div>

            <!-- Sidebar -->
            <aside :class="['h-full w-64 bg-white border-r border-gray-100 shadow-sm transition-transform duration-300 fixed lg:static inset-y-0 left-0 z-50 lg:z-10 shrink-0', 
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0']">
                <sidebar class="h-full w-full" @close="sidebarOpen = false" />
            </aside>
            
            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative">
                <Header class="shrink-0 z-20" @toggle-sidebar="sidebarOpen = !sidebarOpen" />
                <main class="flex-1 overflow-hidden relative bg-[#f8fafc]">
                    <router-view></router-view>
                </main>
            </div>
        </div>

        <div class="flex flex-col h-full w-full overflow-hidden" v-else-if="router.currentRoute.value.name === 'booking'">
            <Header class="shrink-0 z-10" />
            <main class="flex-1 overflow-hidden relative bg-[#f8fafc]">
                <router-view></router-view>
            </main>
        </div>

        <div class="h-full w-full overflow-hidden" v-else>
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
import sidebar from './Layouts/Sidebar.vue';
import Header from './Layouts/Header.vue';
import { useRouter } from 'vue-router';
import { ref } from 'vue';

const router = useRouter();
const sidebarOpen = ref(false);

router.afterEach(() => {
    sidebarOpen.value = false;
});

const token = localStorage.getItem('token');
const routerName = router.currentRoute.value.name;

if (!token && !['login'].includes(router.currentRoute.value.name)) {
    router.push('/');
}

if (routerName == 'login' && token) {
}

</script>

<style>
body {
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
</style>