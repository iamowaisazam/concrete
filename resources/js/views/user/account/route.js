import index from "./index.vue"
import create from "./create.vue"
import edit from "./edit.vue"


export default [
    {
        path: "account",
        children: [
            { 
                path: '', 
                component: index, 
                meta: { requiresAuth: true } 
            },
            { 
                path: 'create', 
                component: create, 
                meta: { requiresAuth: true } 
            },
            { 
                path: 'edit', 
                component: edit, 
                meta: { requiresAuth: true } 
            },
        ],
    },
]
