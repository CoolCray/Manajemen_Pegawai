<template>
    <div class="h-full w-full flex flex-col bg-[#f8fafc] overflow-hidden">
        <div class="px-6 sm:px-10 py-6 sm:py-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shrink-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Pegawai</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola data pegawai anda di sini.</p>
            </div>
            <button @click="openModal"
                class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3.5 rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2 active:scale-95">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Pegawai</span>
            </button>
        </div>

        <div class="px-6 sm:px-10 mb-6 shrink-0">
            <div class="bg-white/70 backdrop-blur-md p-4 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm border border-white/60 grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
                <div class="flex-1">
                    <label class="block text-[10px] w-full font-bold text-gray-400 uppercase tracking-widest mb-2">Divisi</label>
                    <select id="filterDivisi" class="select2 w-full">
                        <option value="">Semua Divisi</option>
                        <option v-for="div in divisions" :key="div.id" :value="div.id">{{ div.name }}</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Posisi</label>
                    <select id="filterPosisi" class="select2 w-full" :disabled="!selectedDivisi">
                        <option value="">{{ selectedDivisi ? 'Pilih Posisi' : 'Pilih Divisi Terlebih Dahulu' }}</option>
                        <option v-for="pos in positions" :key="pos.id" :value="pos.id">{{ pos.name }}</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Bergabung</label>
                    <div class="relative">
                        <input type="text" id="filterDateRange"
                            class="w-full bg-white border border-gray-100 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition"
                            placeholder="Pilih Rentang Tanggal">
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 sm:px-10 pb-6 sm:pb-8 flex-1 overflow-hidden flex flex-col">
            <div class="bg-white rounded-3xl sm:rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden flex flex-col flex-1">
                <div class="p-4 sm:p-8 flex-1 overflow-auto custom-scrollbar">
                    <div class="min-w-[1000px]">
                        <table id="employeeTable" class="w-full display responsive nowrap" style="width:100%">
                            <thead>
                                <tr class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <th>No</th>
                                    <th>Pegawai</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Gaji</th>
                                    <th>Tgl Bergabung</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-600">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <ModalEmployees v-if="showModal" :show="showModal" :employee-id="selectedEmployeeId" :divisions="divisions"
            @close="closeModal" @submit="onFormSubmit" />
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import ModalEmployees from './ModalEmployees.vue';
import axios from 'axios';

const showModal = ref(false);
const selectedEmployeeId = ref(null);
const divisions = ref([]);
const positions = ref([]);
const selectedDivisi = ref(null);
let table = null;

const openModal = () => {
    selectedEmployeeId.value = null;
    showModal.value = true;
};

const editEmployee = (id) => {
    selectedEmployeeId.value = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedEmployeeId.value = null;
};

const onFormSubmit = () => {
    if (table) table.ajax.reload();
};

// Expose functions to window for DataTable buttons
window.editEmployee = (id) => {
    editEmployee(id);
};

window.deleteEmployee = (id) => {
    Swal.fire({
        title: 'Hapus Pegawai?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await axios.delete(`/employees-management/${id}`);
                if (table) table.ajax.reload();
                Swal.fire('Terhapus!', 'Data pegawai telah dihapus.', 'success');
            } catch (error) {
                Swal.fire('Error!', 'Gagal menghapus data.', 'error');
            }
        }
    });
};

onMounted(async () => {
    $('#filterDivisi').select2({ placeholder: "Pilih Divisi", allowClear: true });
    $('#filterPosisi').select2({ placeholder: "Pilih Posisi", allowClear: true });

    $('#filterDivisi').on('change', async function () {
        selectedDivisi.value = $(this).val();
        if (selectedDivisi.value) {
            const posRes = await axios.get(`/employees-management/positions/${selectedDivisi.value}`);
            positions.value = posRes.data;
        } else {
            positions.value = [];
        }
        if (table) table.draw();
    });

    $('#filterPosisi').on('change', function () {
        if (table) table.draw();
    });

    $('#filterDateRange').daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: 'Reset', format: 'YYYY-MM-DD' }
    });

    $('#filterDateRange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        if (table) table.draw();
    });

    $('#filterDateRange').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        if (table) table.draw();
    });

    table = $('#employeeTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/employees-management/list",
            data: function (d) {
                d.division_id = $('#filterDivisi').val();
                d.position_id = $('#filterPosisi').val();
                d.date_range = $('#filterDateRange').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: null,
                name: 'name',
                render: function (data, type, row) {
                    let url = row.profile_picture_url;
                    return `
                        <div class="flex items-center gap-4">
                            <div class="relative group shrink-0">
                                <img src="${url}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm transition-transform group-hover:scale-105">
                                <div class="absolute inset-0 rounded-full shadow-inner"></div>
                            </div>
                            <div class="flex flex-col text-left">
                                <span class="font-bold text-gray-900 leading-tight">${row.name}</span>
                                <span class="text-xs text-gray-400 font-medium">${row.email}</span>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'nip', name: 'nip' },
            {
                data: 'position.name',
                name: 'position.name',
                render: function (data, type, row) {
                    return `
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-700">${data}</span>
                            <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-wider">${row.position.division.name}</span>
                        </div>
                    `;
                }
            },
            { data: 'salary', name: 'salary' },
            {
                data: 'join_date',
                name: 'join_date',
                render: function (data) {
                    return moment(data).format('DD MMM YYYY');
                }
            },
            {
                data: 'id',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="editEmployee(${data})" class="p-2 bg-yellow-50 text-yellow-600 hover:bg-yellow-600 hover:text-white rounded-lg transition-all duration-200">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button onclick="deleteEmployee(${data})" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-200">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    `;
                }
            },
        ],
        language: {
            searchPlaceholder: "Cari pegawai...",
            search: "",
            lengthMenu: "Tampil _MENU_",
            info: "Baris _START_ - _END_ dari _TOTAL_",
            paginate: { next: '<i class="bi bi-chevron-right"></i>', previous: '<i class="bi bi-chevron-left"></i>' }
        },
        drawCallback: function () {
            $('.dataTables_paginate > .paginate_button').addClass('flex items-center justify-center w-8 h-8 rounded-lg border-none bg-white text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors mx-0.5');
            $('.dataTables_paginate > .paginate_button.current').addClass('!bg-indigo-600 !text-white shadow-md shadow-indigo-100');
        }
    });

    try {
        const divRes = await axios.get('/employees-management/positions/list-all-divisions');
        divisions.value = divRes.data;
    } catch (error) {
        console.error('Error fetching divisions:', error);
    }
});

onUnmounted(() => {
    if (table) table.destroy();
    delete window.editEmployee;
    delete window.deleteEmployee;
});
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
    background: #e2e8f0;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}

.dataTables_wrapper .dataTables_filter { display: block; margin-bottom: 1rem; }
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #f1f5f9;
    border-radius: 0.75rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    outline: none;
    transition: all 0.2s;
    background: #f8fafc;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #4f46e5;
    background: white;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.05);
}
table.dataTable.no-footer { border-bottom: none !important; }
.dataTables_processing { background: rgba(255, 255, 255, 0.9) !important; border: none !important; color: #4f46e5 !important; font-weight: bold; border-radius: 16px; backdrop-filter: blur(8px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
.dataTables_length select { border-radius: 8px; border-color: #f1f5f9; padding: 4px 8px; font-size: 12px; outline: none; background: #f8fafc; }
.dataTables_info { font-size: 11px; color: #94a3b8; font-weight: 600; padding-top: 1.25rem !important; text-transform: uppercase; letter-spacing: 0.025em; }
.dataTables_paginate { padding-top: 1rem !important; }

.select2-container--default .select2-selection--single {
    border: 1px solid #f1f5f9;
    border-radius: 0.75rem;
    height: 2.75rem;
    display: flex;
    align-items: center;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    background-color: #fff;
    transition: all 0.2s;
}
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #4f46e5;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.05);
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    font-size: 0.875rem;
    color: #1e293b;
    font-weight: 500;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 2.75rem;
}
.select2-dropdown {
    border: 1px solid #f1f5f9;
    border-radius: 1rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-top: 4px;
}
.select2-results__option {
    font-size: 0.875rem;
    padding: 0.625rem 1rem;
    color: #475569;
}
.select2-results__option--highlighted[aria-selected] {
    background-color: #4f46e5 !important;
}
</style>