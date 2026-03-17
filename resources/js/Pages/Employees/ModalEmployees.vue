<template>
    <div v-show="show" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 backdrop-blur-md p-2 sm:p-6 animate-in fade-in duration-300">
        <div class="relative w-full max-w-4xl max-h-[95vh] h-full sm:h-auto flex flex-col transform transition-all animate-in zoom-in-95 duration-300">
            <div class="bg-white rounded-2xl sm:rounded-[2.5rem] shadow-2xl overflow-hidden shadow-indigo-200/20 flex flex-col border border-white/40 h-full sm:h-auto">
                <div class="px-6 sm:px-8 py-4 sm:py-6 border-b border-gray-50 flex justify-between items-center bg-white/50 backdrop-blur-sm shrink-0">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">{{ employeeId ? 'Edit Data Pegawai' : 'Tambah Pegawai Baru' }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            Lengkapi informasi di bawah ini
                        </p>
                    </div>
                    <button @click="$emit('close')" class="w-10 h-10 flex items-center justify-center rounded-2xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200">
                        <i class="bi bi-x-lg text-lg text-gray-400"></i>
                    </button>
                </div>
                
                <form id="employeeForm" @submit.prevent class="flex-1 overflow-auto custom-scrollbar">
                    <input type="hidden" name="id" v-model="formData.id">
                    <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6 sm:gap-y-8 bg-white">
                        
                        <div class="space-y-6">
                            <h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-4 h-px bg-indigo-500"></span>Informasi Pribadi
                            </h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Nama Lengkap</label>
                                    <div class="relative group">
                                        <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                        <input type="text" name="name" v-model="formData.name" 
                                            class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl pl-11 pr-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all" 
                                            placeholder="Contoh: John Doe">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">NIP</label>
                                    <div class="relative group">
                                        <i class="bi bi-card-text absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                        <input type="text" name="nip" v-model="formData.nip" 
                                            class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl pl-11 pr-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all" 
                                            placeholder="Nomor Induk Pegawai">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Email</label>
                                        <input type="email" name="email" v-model="formData.email" 
                                            class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all" 
                                            placeholder="john@example.com">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Telepon</label>
                                        <input type="text" name="phone" v-model="formData.phone" 
                                            class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all" 
                                            placeholder="0812...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-4 h-px bg-indigo-500"></span>Pekerjaan & Berkas
                            </h4>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Divisi</label>
                                        <select id="formDivisi" name="division_id" class="select2 w-full">
                                            <option value="">Pilih</option>
                                            <option v-for="div in divisions" :key="div.id" :value="div.id">{{ div.name }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Posisi</label>
                                        <select id="formPosisi" name="position_id" class="select2 w-full">
                                            <option value="">Pilih</option>
                                            <option v-for="pos in positions" :key="pos.id" :value="pos.id">{{ pos.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Gaji (Rp)</label>
                                        <input type="number" name="salary" v-model="formData.salary" 
                                            class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Tgl Bergabung</label>
                                        <div class="relative group">
                                            <i class="bi bi-calendar-event absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-500 transition-colors pointer-events-none"></i>
                                            <input type="text" id="join_date" name="join_date" 
                                                class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl pl-11 pr-4 py-3 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all datepicker">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Foto Profil</label>
                                    <div id="dropzoneProfile" class="dropzone p-4 bg-gray-50/50 rounded-[2rem] border-2 border-dashed border-gray-100 hover:border-indigo-400 hover:bg-indigo-50/30 transition-all cursor-pointer">
                                        <div class="dz-message flex flex-col items-center gap-1 py-1">
                                            <i class="bi bi-cloud-arrow-up text-3xl text-indigo-600"></i>
                                            <span class="text-xs font-bold text-gray-600">Klik atau drop file</span>
                                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">JPG/PNG MAX 2MB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-3">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Alamat Lengkap</label>
                            <textarea name="address" v-model="formData.address" rows="3" 
                                class="w-full bg-gray-50/50 border border-gray-100 rounded-[2rem] px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 focus:bg-white outline-none transition-all" 
                                placeholder="Jl. Raya No. 123..."></textarea>
                        </div>
                    </div>

                    <div class="px-6 sm:px-8 py-4 sm:py-6 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3 shrink-0 mt-auto">
                        <button type="button" @click="$emit('close')" 
                            class="px-8 py-3 font-bold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest text-[10px] w-full sm:w-auto">Batal</button>
                        <button type="submit" id="btnSubmit" 
                            class="px-10 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-[11px] w-full sm:w-auto">
                            Simpan Data Pegawai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, defineProps, defineEmits, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    show: Boolean,
    employeeId: Number,
    divisions: Array
});

const emit = defineEmits(['close', 'submit']);

const formData = ref({
    id: '',
    name: '',
    nip: '',
    email: '',
    phone: '',
    salary: '',
    join_date: '',
    address: '',
    position_id: '',
    division_id: ''
});

const positions = ref([]);
let myDropzone = null;

const fetchEmployeesDetail = async () => {
    if (!props.employeeId) return;
    try {
        const res = await axios.get(`/employees-management/${props.employeeId}`);
        const data = res.data;
        formData.value = { ...data, division_id: data.position.division_id };
        
        if (formData.value.division_id) {
            const posRes = await axios.get(`/employees-management/positions/${formData.value.division_id}`);
            positions.value = posRes.data;
        }

        $('#formDivisi').val(formData.value.division_id).trigger('change');
        setTimeout(() => {
            $('#formPosisi').val(formData.value.position_id).trigger('change');
        }, 100);
        $('#join_date').val(data.join_date.split('T')[0]);
    } catch (e) {
        console.error(e);
    }
};

onMounted(() => {
    $('#formDivisi').select2({ placeholder: "Pilih Divisi", dropdownParent: $('#employeeForm') });
    $('#formPosisi').select2({ placeholder: "Pilih Posisi", dropdownParent: $('#employeeForm') });

    $('#formDivisi').on('change', async function() {
        const val = $(this).val();
        formData.value.division_id = val;
        if (val) {
            const res = await axios.get(`/employees-management/positions/${val}`);
            positions.value = res.data;
        } else {
            positions.value = [];
        }
        $('#formPosisi').val('').trigger('change');
    });

    $('#formPosisi').on('change', function() {
        formData.value.position_id = $(this).val();
    });

    $('#join_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: true,
        locale: { format: 'YYYY-MM-DD' }
    });

    Dropzone.autoDiscover = false;
    myDropzone = new Dropzone("#dropzoneProfile", {
        url: "#",
        autoProcessQueue: false,
        maxFiles: 1,
        acceptedFiles: "image/*",
        init: function() {
            this.on("addedfile", function() {
                if (this.files.length > 1) this.removeFile(this.files[0]);
            });
        }
    });

    $("#employeeForm").validate({
        rules: {
            name: "required",
            nip: "required",
            email: { required: true, email: true },
            phone: "required",
            salary: "required",
            address: "required",
            division_id: "required",
            position_id: "required"
        },
        errorElement: "div",
        errorClass: "text-[10px] font-bold text-red-500 mt-1 uppercase tracking-tight",
        submitHandler: function(form) {
            submitForm();
        }
    });

    if (props.employeeId) {
        fetchEmployeesDetail();
    }
});

const submitForm = async () => {
    const data = new FormData();
    Object.keys(formData.value).forEach(key => {
        if (formData.value[key]) data.append(key, formData.value[key]);
    });
    
    data.set('join_date', $('#join_date').val());
    data.set('position_id', $('#formPosisi').val());

    if (myDropzone.getAcceptedFiles().length > 0) {
        data.append('profile_picture', myDropzone.getAcceptedFiles()[0]);
    }

    const url = props.employeeId ? `/employees-management/${props.employeeId}/update` : '/employees-management/store';
    
    $('#btnSubmit').prop('disabled', true).text('Memproses...');

    try {
        const res = await axios.post(url, data, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        Swal.fire('Berhasil!', res.data.message, 'success');
        emit('submit');
        emit('close');
    } catch (error) {
        const msg = error.response?.data?.message || 'Terjadi kesalahan.';
        Swal.fire('Gagal!', msg, 'error');
    } finally {
        $('#btnSubmit').prop('disabled', false).text('Simpan Data Pegawai');
    }
};
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #f1f5f9;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #e2e8f0;
}

.dropzone .dz-preview { display: none !important; }
.dropzone.dz-started .dz-message { display: block !important; opacity: 0.5; }

input.error, select.error, textarea.error {
    border-color: #fee2e2 !important;
    background-color: #fffafb !important;
}

.select2-container--default .select2-selection--single {
    border: 1px solid #f1f5f9;
    border-radius: 1rem;
    height: 3rem;
    display: flex;
    align-items: center;
    padding-left: 0.75rem;
    background-color: rgba(249, 250, 251, 0.5);
    transition: all 0.2s;
}

.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #4f46e5;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.05);
}
</style>