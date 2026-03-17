<template>
    <div class="flex flex-col justify-center items-center h-screen">
        <div class="p-10 rounded-lg bg-white xl:w-96 lg:w-80 md:w-72 w-64 shadow-lg flex flex-col gap-8">
            <header class="flex flex-col items-center justify-center text-center">
                <img src="https://images.glints.com/unsafe/glints-dashboard.oss-ap-southeast-1.aliyuncs.com/company-logo/9260d9778d98342935935d60549c65c7.png" alt="Company Logo" class="h-10 w-auto object-contain ">
                <h1 class="font-semibold text-2xl text-center">Sistem Pegawai</h1>
            </header>

            <form class="flex flex-col gap-5" @submit.prevent="handlelogin">
                <div class="justify-center flex flex-col ">
                    <span>Username</span>
                    <input v-model="username" placeholder="Masukkan Username" type="text" class="border-1 border-gray-200 rounded-md text-black py-2 px-4 w-full">
                </div>
                <div class="flex flex-col">
                    <span>Password</span>
                    <input v-model="password" placeholder="Masukkan Password" type="password" class="border-1 border-gray-200 rounded-md text-black py-2 px-4">
                </div>
                <ButtonOren text="Login" />
            </form>
        </div>
    </div>

</template>

<script setup>
import ButtonOren from '../../Components/ButtonOren.vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
const token = localStorage.getItem('token');
const username = ref('');
const password = ref('');

const router = useRouter();

async function handlelogin(){
    try{
        const response = await axios.post('api/login', {
            username: username.value,
            password: password.value
        });
        
        if(response.status === 200){
            const token = response.data.data.token;
            localStorage.setItem('token', token);
            localStorage.setItem('user', username.value);

            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            router.push('/dashboard');
        } 
    }

    catch(error){
        alert('Username dan Password salah!');
    }
}


if(token){
    router.push('/dashboard');
}




</script>

<style scoped></style>