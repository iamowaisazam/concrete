import Login from "@views/auth/login.vue"
import Register from '@views/auth/register.vue';




export default [
    {
        path: "/",
        children: [
            { path: 'login', component: Login},
            { path: 'register', component: Register},
        ],
    },
]
