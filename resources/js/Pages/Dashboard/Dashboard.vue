<template>
    <div class="h-full w-full flex flex-col bg-[#f8fafc] overflow-hidden">
        <div class="px-6 sm:px-10 py-6 sm:py-8 shrink-0">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Statistik</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan data hari ini.</p>
        </div>

        <div class="px-6 sm:px-10 pb-4 shrink-0 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
            <div class="bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 transition-transform group-hover:scale-110">
                    <i class="bi bi-people-fill text-6xl text-indigo-600"></i>
                </div>
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="bi bi-people-fill text-2xl text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Pegawai</p>
                    <h3 class="text-xl font-black text-gray-900">{{ dashboardData.total_employees }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 transition-transform group-hover:scale-110">
                    <i class="bi bi-diagram-3-fill text-6xl text-orange-500"></i>
                </div>
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="bi bi-diagram-3-fill text-2xl text-orange-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Divisi</p>
                    <h3 class="text-xl font-black text-gray-900">{{ dashboardData.total_divisions }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 transition-transform group-hover:scale-110">
                    <i class="bi bi-wallet2 text-6xl text-emerald-500"></i>
                </div>
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="bi bi-wallet2 text-2xl text-emerald-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Anggaran Gaji</p>
                    <h3 class="text-xl font-black text-gray-900">{{ formatCurrency(dashboardData.total_salary_monthly) }}</h3>
                </div>
            </div>
        </div>

        <div class="px-10 pb-8 flex-1 overflow-hidden flex flex-col pt-4">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden flex flex-col flex-1">
                <div class="px-4 sm:px-8 py-4 sm:py-6 border-b border-gray-50 flex justify-between items-center bg-white/50 backdrop-blur-sm shrink-0">
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-gray-900 tracking-tight">Pegawai Terakhir Bergabung</h2>
                        <p class="text-[10px] sm:text-xs text-gray-400 font-medium">Data 10 pegawai terbaru yang masuk dalam sistem.</p>
                    </div>
                </div>
                <div class="px-4 sm:px-8 py-4 flex-1 overflow-auto custom-scrollbar">
                    <div class="min-w-[600px]">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="pb-4 pl-4">Pegawai</th>
                                    <th class="pb-4">Posisi</th>
                                    <th class="pb-4">Divisi</th>
                                    <th class="pb-4">Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="loading">
                                    <td colspan="4" class="text-center py-20">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-10 h-10 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                                            <p class="text-sm font-bold text-gray-400">Memuat data...</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else-if="dashboardData.recent_employees.length === 0">
                                    <td colspan="4" class="text-center py-20 text-gray-400 font-bold">Belum ada data pegawai.</td>
                                </tr>
                                <tr v-for="emp in dashboardData.recent_employees" :key="emp.id" class="group transition-all">
                                    <td class="py-3 pl-4 bg-gray-50/50 group-hover:bg-indigo-50/50 rounded-l-2xl border-l border-t border-b border-transparent group-hover:border-indigo-100 transition-all">
                                        <div class="flex items-center gap-3">
                                            <img :src="emp.profile_picture_url" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm shrink-0">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-900 leading-tight truncate max-w-[120px]">{{ emp.name }}</span>
                                                <span class="text-[10px] text-gray-400 font-bold truncate max-w-[120px]">{{ emp.email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 bg-gray-50/50 group-hover:bg-indigo-50/50 border-t border-b border-transparent group-hover:border-indigo-100 transition-all">
                                        <span class="text-sm font-bold text-gray-700">{{ emp.position }}</span>
                                    </td>
                                    <td class="py-3 bg-gray-50/50 group-hover:bg-indigo-50/50 border-t border-b border-transparent group-hover:border-indigo-100 transition-all">
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-wider">{{ emp.division }}</span>
                                    </td>
                                    <td class="py-3 pr-4 bg-gray-50/50 group-hover:bg-indigo-50/50 rounded-r-2xl border-r border-t border-b border-transparent group-hover:border-indigo-100 transition-all text-sm font-bold text-gray-500">
                                        {{ formatDate(emp.join_date) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';

moment.locale('id');

const loading = ref(true);
const dashboardData = ref({
    total_employees: 0,
    total_divisions: 0,
    total_salary_monthly: 0,
    recent_employees: []
});

const fetchDashboardData = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/dashboard');
        if (response.data.status === 'success') {
            dashboardData.value = response.data.data;
        }
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    } finally {
        loading.value = false;
    }
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(value);
};

const formatDate = (dateString) => {
    return moment(dateString).format('DD MMM YYYY');
};

onMounted(() => {
    fetchDashboardData();
});

</script>

<style scoped>
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
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>