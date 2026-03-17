<template>
    <div class="h-full w-full flex flex-col bg-[#f8fafc] overflow-hidden">
        <div class="px-6 sm:px-10 py-6 sm:py-8 shrink-0 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">User Management</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola hak akses dan akun pengguna sistem.</p>
            </div>

            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-80 group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600">
                        <i class="bi bi-search text-gray-400"></i>
                    </span>
                    <input type="text" placeholder="Cari user..." v-model="search" @keyup="searchUser"
                        class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-2xl leading-5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 shadow-sm shadow-gray-100/50">
                </div>
                <button @click="openModal" 
                    class="flex items-center gap-2 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold transition-all duration-300 shadow-lg shadow-indigo-200 active:scale-[0.98] shrink-0">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah User</span>
                </button>
            </div>
        </div>

        <div class="px-6 sm:px-10 pb-6 sm:pb-10 flex-1 overflow-hidden flex flex-col pt-4">
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl sm:rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-white/40 overflow-hidden flex flex-col flex-1 relative">
                <div class="overflow-auto flex-1 custom-scrollbar px-4 sm:px-6 pt-4">
                    <div class="min-w-[500px]">
                        <table class="w-full text-left border-separate border-spacing-y-4">
                            <thead class="sticky top-0 z-20">
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] bg-white/50 backdrop-blur-md">
                                    <th class="pb-4 pl-6">No</th>
                                    <th class="pb-4">Username</th>
                                    <th class="pb-4">Email</th>
                                    <th class="pb-4 text-center pr-6">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-if="!data.data || data.data.length === 0">
                                    <td colspan="4" class="py-20 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center">
                                                <i class="bi bi-person-exclamation text-3xl text-gray-300"></i>
                                            </div>
                                            <p class="text-gray-400 font-bold">Belum ada data user yang terdaftar.</p>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-else v-for="(item, index) in data.data" :key="item.id || index"
                                    class="group transition-all duration-300 hover:translate-x-1">
                                    <td class="py-4 pl-6 bg-gray-50/50 group-hover:bg-indigo-50/50 rounded-l-2xl border-l border-t border-b border-transparent group-hover:border-indigo-100 transition-all duration-300 text-sm font-bold text-gray-400">
                                        {{ (data.current_page - 1) * data.per_page + index + 1 }}
                                    </td>
                                    <td class="py-4 bg-gray-50/50 group-hover:bg-indigo-50/50 border-t border-b border-transparent group-hover:border-indigo-100 transition-all duration-300">
                                        <div class="flex items-center gap-3">
                                            <span class="font-bold text-gray-900 leading-tight">{{ item.username }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 bg-gray-50/50 group-hover:bg-indigo-50/50 border-t border-b border-transparent group-hover:border-indigo-100 transition-all duration-300">
                                        <span class="text-sm font-bold text-gray-500">{{ item.email }}</span>
                                    </td>
                                    <td class="py-4 pr-6 bg-gray-50/50 group-hover:bg-indigo-50/50 rounded-r-2xl border-r border-t border-b border-transparent group-hover:border-indigo-100 transition-all duration-300">
                                        <div class="flex justify-center gap-2">
                                            <button @click="updateUser(item)"
                                                class="w-8 h-8 flex items-center justify-center bg-white hover:bg-amber-500 text-amber-500 hover:text-white rounded-lg shadow-sm border border-gray-100 transition-all active:scale-95 group/btn">
                                                <i class="bi bi-pencil-square transition-transform group-hover/btn:scale-110"></i>
                                            </button>
                                            <button @click="deleteUser(item.id)"
                                                class="w-8 h-8 flex items-center justify-center bg-white hover:bg-rose-500 text-rose-500 hover:text-white rounded-lg shadow-sm border border-gray-100 transition-all active:scale-95 group/btn">
                                                <i class="bi bi-trash3-fill transition-transform group-hover/btn:scale-110"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-6 sm:px-10 py-4 shrink-0 bg-white/50 backdrop-blur-md border-t border-gray-50">
                    <Pagination :currentPage="data.current_page" :totalPages="data.last_page" @update:page="fetchUser" />
                </div>
            </div>
        </div>

        <ModalUser v-if="showModal" :showModal="showModal" @close="closeModal" @fetchUser="fetchUser" :isEdit="isEdit"
            :userSelected="userSelected" />
    </div>
</template>

<script setup>
import Pagination from '../../Components/Pagination.vue';
import ModalUser from './ModalUser.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const data = ref({
    data: [],
    current_page: 1,
    last_page: 1,
    per_page: 10
});
const search = ref('');
const showModal = ref(false);
const isEdit = ref(false);
const userSelected = ref(null);

const searchUser = async (page = 1) => {
    try {
        const response = await axios.get(`api/user/search?query=${search.value}&page=${page}`);
        data.value = response.data;
    }
    catch (error) {
        console.error(error);
    }
};

const fetchUser = async (page = 1) => {
    try {
        const response = await axios.get(`api/user?page=${page}`);
        data.value = response.data;
    }
    catch (error) {
        console.error(error);
    }
};

const deleteUser = async (id) => {
    const result = await Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data user akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#f43f5e',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#ffffff',
        customClass: {
            popup: 'rounded-[2rem] border-none shadow-2xl',
            confirmButton: 'rounded-xl px-6 py-3 font-bold',
            cancelButton: 'rounded-xl px-6 py-3 font-bold'
        }
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`api/user/${id}`);
            fetchUser();
            Swal.fire({
                title: 'Berhasil!',
                text: 'User telah dihapus.',
                icon: 'success',
                confirmButtonColor: '#4f46e5',
                customClass: {
                    popup: 'rounded-[2rem] border-none shadow-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold'
                }
            });
        }
        catch (error) {
            console.error(error);
            Swal.fire('Error', 'Gagal menghapus user.', 'error');
        }
    }
};

const updateUser = (item) => {
    userSelected.value = item;
    isEdit.value = true;
    showModal.value = true;
};

const openModal = () => {
    isEdit.value = false;
    userSelected.value = null;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

onMounted(() => {
    fetchUser();
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