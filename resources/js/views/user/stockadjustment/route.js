import index from "./index.vue"
import create from "./create.vue"
import edit from "./edit.vue"


export default [
    {
        path: "stockadjustment",
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
                path: 'edit/:id', 
                component: edit, 
                meta: { requiresAuth: true } 
            },
            
        ],
    },
]
