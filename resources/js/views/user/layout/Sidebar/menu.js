export default [
       
        {
            icon: "mdi-view-dashboard-outline",
            label: "Dashboard",
            path: "/user/dashboard",
        },
        {
            icon: "mdi-account-multiple",
            label: "Account",
            path: "/user/account",
        },
        {
            icon: "mdi-package",
            label: "Items",
            path: "/user/watchlist",
        },
        {
            icon: "mdi-receipt-text-outline",
            label: "Sales",
            path: "/user/auction-finder",
        },
        {
            icon: "mdi-receipt-text-edit",
            label: "Purchase",
            path: "/user/auction-finder",
        },
        {
            icon: "mdi-car-search-outline",
            label: "Expense",
            path: "/user/auction-finder",
        },
         {
            icon: "mdi-file-chart",
            label: "Reports",
            path: "/user/auction-finder",
            chiildren: [
                {
                    label: "Ledger Report",
                },    
            ]
        },
        {
            icon: "mdi-cog-outline",
            label: "Settings",
            path: "/user/settings/profile",
        },
    ];