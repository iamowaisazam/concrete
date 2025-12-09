
import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '@stores/userStore';
import { useAlertStore } from '@stores/alertStore';

import NotFound from "@views/user/404.vue"
import userRoutes from "./userRoutes"
import Login from '@/views/auth/login.vue';


const suburl = import.meta.env.VITE_SUB_URL;

const routes = [
    { path: '/', component: Login},
    { path: '/login', component: Login},
    ...userRoutes,
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: NotFound
    },
];

const router = createRouter({
    history: createWebHistory(suburl),
    routes,
});



router.beforeEach(async (to, from, next) => {


    const auth = useUserStore()
    const alertStore = useAlertStore()

    //Auth Restriction

        try {

            const res = await auth.getProfile();
            auth.user = res.user;
            auth.is_logged_in = true;
            
        } catch (error) {
            auth.user = {};
            auth.is_logged_in = false;
            localStorage.removeItem('auth_token');
        }
    
    
    if (to.meta.requiresAuth){
        if (auth.is_logged_in) {
            next()
        }else{
            next('/login');
        }

    } else {
        next()
    }



});

export default router;