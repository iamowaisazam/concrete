import index from "./index.vue"
import create from "./create.vue"
import edit from "./edit.vue"


export default [
    {
        path: "payments",
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
