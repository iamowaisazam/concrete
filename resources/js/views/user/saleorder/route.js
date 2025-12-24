import index from "./index.vue"
import create from "./create.vue"
import edit from "./edit/index.vue"


export default [
    {
        path: "saleorder",
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
