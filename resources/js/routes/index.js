
import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '@stores/userStore';
import { useAlertStore } from '@stores/alertStore';




// Routes...
import Layout from "@views/user/layout/index.vue";
import NotFound from "@views/user/404.vue"
import Login from '@/views/auth/login.vue';
import Dashboard from '@views/user/dashboard/index.vue';
import accountRoutes from "@views/user/account/route"
import inventoryRoute from "@views/user/Inventory/route"
import categoryRoute from "@views/user/category/route"
import expensecategoryRoute from "@views/user/ExpenseCategory/route"
import expenseRoute from "@views/user/Expense/route" 
import unitRoute from "@/views/user/unit/route"
import reportRoute from "@/views/user/reports/route"
import saleInvoiceRoute from "@/views/user/saleInvoice/route"
import paymentsRoute from "@/views/user/payments/route"
import stockadjustmentRoute from "@views/user/stockadjustment/route"
import saleorderRoute from "@views/user/saleorder/route"
import deliverynoteRoute from "@views/user/deliverynote/route"
import Forget  from '@/views/auth/forget.vue';



const suburl = import.meta.env.VITE_SUB_URL;

const routes = [

    { path: '/', component: Login},
    { path: '/login', component: Login},
    { path: '/forgetpassowrd',name: 'forgot-password', component: Forget},
    {
        path: "/user",
        component: Layout,
        children: [
            { path: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
            ...accountRoutes,
            ...inventoryRoute,
            ...categoryRoute,
            ...expensecategoryRoute,
            ...expenseRoute,
            ...unitRoute,
            ...reportRoute,
            ...saleInvoiceRoute,
            ...paymentsRoute,
            ...stockadjustmentRoute,
            ...saleorderRoute,
            ...deliverynoteRoute,
        ],
    },
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