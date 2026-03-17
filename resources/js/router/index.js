
import { createRouter, createWebHistory } from 'vue-router';

import Login from '../Pages/Auth/Login.vue'; 
import Dashboard from '../Pages/Dashboard/Dashboard.vue'; 
import CustomerManagement from '../Pages/Customer/CustomerManagement.vue';
import UserManagement from '../Pages/User/UserManagement.vue';
import EmployeesManagemnt from '../Pages/Employees/EmployeesManagemnt.vue';

const routes = [
    {
        path: '/',
        name: 'login',
        component: Login
    },

    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/user',
        name: 'user',
        component: UserManagement
    },
    {
        path: '/customer',
        name: 'customer',
        component: CustomerManagement
    },
    {
        path: '/employees',
        name: 'employees',
        component: EmployeesManagemnt
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;