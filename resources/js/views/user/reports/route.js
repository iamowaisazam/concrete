
import AccountLedger from "./accountLedger.vue"
import AccountLedgerDetail from "./accountLedgerDetail.vue"



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
            
        ],
    },
]
