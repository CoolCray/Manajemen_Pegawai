<template>
    <div v-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 backdrop-blur-md p-2 sm:p-4 animate-in fade-in duration-300">
        <div class="relative w-full max-w-lg transform transition-all animate-in zoom-in-95 duration-300">
            <div class="bg-white rounded-2xl sm:rounded-[2.5rem] shadow-2xl overflow-hidden shadow-indigo-200/20 flex flex-col border border-white/40">
                <div class="px-6 sm:px-8 py-4 sm:py-6 border-b border-gray-50 flex justify-between items-center bg-white/50 backdrop-blur-sm shrink-0">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">{{ judul }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            Lengkapi informasi akun di bawah ini
                        </p>
                    </div>
                    <button @click="$emit('close')" class="w-10 h-10 flex items-center justify-center rounded-2xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200">
                        <i class="bi bi-x-lg text-lg"></i>
                    </button>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    <form @submit.prevent="submitForm" class="space-y-5">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Username</label>
                                <div class="relative group">

                                    <input v-model="username" type="text" placeholder="Masukkan username"
                                        class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl pl-11 pr-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Email</label>
                                <div class="relative group">
                                    <input v-model="email" type="email" placeholder="nama@email.com"
                                        class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl pl-11 pr-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Password</label>
                                <div class="relative group">
                                    <input v-model="password" type="password" :placeholder="isEdit ? 'Kosongkan jika tidak diubah' : 'Masukan Password'"
                                        class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl pl-11 pr-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="px-6 sm:px-8 py-4 sm:py-6 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3 shrink-0">
                    <button type="button" @click="$emit('close')" 
                        class="px-8 py-3 font-bold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest text-[10px] w-full sm:w-auto">Batal</button>
                    <button @click="submitForm" type="submit"
                        class="px-10 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-[11px] w-full sm:w-auto">
                        Simpan Data User
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    showModal: Boolean,
    isEdit: Boolean,
    userSelected: Object
});

const emit = defineEmits(['close', 'fetchUser']);

const username = ref('');
const email = ref('');
const password = ref('');

const judul = computed(() => {
    return props.isEdit ? 'Ubah Data User' : 'Tambah User Baru';
});

onMounted(() => {
    if(props.isEdit && props.userSelected){
        username.value = props.userSelected.username;
        email.value = props.userSelected.email;
    }
});

async function submitForm() {
    if (!username.value || !email.value || (!props.isEdit && !password.value)) {
        Swal.fire({
            title: 'Gagal!',
            text: 'Harap lengkapi semua field yang wajib diisi.',
            icon: 'error',
            confirmButtonColor: '#4f46e5',
            customClass: {
                popup: 'rounded-[2rem] border-none shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold'
            }
        });
        return;
    }

    try {
        const payload = {
            username: username.value,
            email: email.value
        };
        if (password.value) payload.password = password.value;

        const response = await axios.post(props.isEdit ? `api/user/${props.userSelected.id}` : 'api/user', payload);
        
        if(response.status === 200 || response.status === 201){
            Swal.fire({
                title: 'Berhasil!',
                text: 'User berhasil ' + (props.isEdit ? 'diupdate' : 'ditambahkan'),
                icon: 'success',
                confirmButtonColor: '#4f46e5',
                customClass: {
                    popup: 'rounded-[2rem] border-none shadow-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold'
                }
            });
            emit('close');
            emit('fetchUser');
        }
    } catch (error) {
        console.error(error);
        Swal.fire({
            title: 'Error!',
            text: error.response?.data?.message || 'Terjadi kesalahan sistem.',
            icon: 'error',
            confirmButtonColor: '#4f46e5',
            customClass: {
                popup: 'rounded-[2rem] border-none shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold'
            }
        });
    }
};
</script>