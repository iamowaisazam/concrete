
import AccountLedger from "./accountLedger.vue"
import AccountLedgerDetail from "./accountLedgerDetail.vue"
import Inventory from "./inventory.vue"
import inventoryDetail from "./inventoryDetail.vue"


export default [
    {
        path: "reports",
        children: [
            { 
                path: 'accountLedger', 
                component: AccountLedger, 
                meta: { requiresAuth: true } 
            },
            { 
                path: 'accountLedgerDetail/:id', 
                component: AccountLedgerDetail, 
                meta: { requiresAuth: true } 
            },
            { 
                path: 'inventory', 
                component: Inventory, 
                meta: { requiresAuth: true } 
            },
              { 
                path: 'inventory/:id', 
                component: inventoryDetail, 
                meta: { requiresAuth: true } 
            },
            
            
        ],
    },
]
