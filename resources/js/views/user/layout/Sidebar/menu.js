export default [
       
        {
            icon: "mdi-view-dashboard-outline",
            label: "Dashboard",
            path: "/user/dashboard",
        },
        {
            icon: "mdi-account-multiple",
            label: "Account",
            path: "/",
            children:[
                {
              
                    label: "Account List",
                    path: "/user/account",
                },
                {
            
                    label: "Receive / Payable",
                    path: "/user/payments",
                },

            ]
        },
        {
            icon: "mdi-warehouse",
            label: "Inventory",
            path: "/user/inventory",
            children:[
                {
                    label: "Unit",
                    path: "/user/unit",
                },
                {
                    label: "Category",
                    path: "/user/category",
                },
                {
                    label: "Items",
                    path: "/user/inventory",
                },
                {
                    label: "Stock Adjustment",
                    path:"/user/stockadjustment"
                
                },
            ]
        },
        // {
        //     icon: "mdi-file-chart",
        //     label: "Sales",
        //     path: "/",
        //     children:[
                // {
                //     label: "Delivery Challan",
                // },
                // {
                //     label: "Sale Invoice",
                //     path: "/user/saleInvoice",
                // },

        //     ]
        // },
        {
            icon: "mdi-cash-multiple",
            label: "Sales Management",
            children:[
            
                {
              
                    label: "Sale Order",
                    path: "/user/saleorder",
                },
                {
            
                    label: "Delivery Note",
                    path: "/user/deliverynote",
                },
                {
                        label: "Sale Invoice",
                        path: "/user/saleInvoice",
                },
                // {
                //     label: "Delivery Challan",
                // },

            ]
        },
        {
            icon: "mdi-cash-multiple",
            label: "Expense",
            children:[
                {
              
                    label: "Expense Category",
                    path: "/user/expensecategory",
                },
                {
            
                    label: "Expense",
                    path: "/user/expense",
                },

            ]
        },
    
        {
            icon: "mdi-file",
            label: "Reports",
            children:[
                {
                    label: "Account Ledger",
                    path: "/user/reports/accountLedger",
                },
                {
                    label: "Inventory",
                    path: "/user/reports/inventory",
                },
            ]
        },
    
        // {
        //     icon: "mdi-package",
        //     label: "Items",
        //     path: "/user/watchlist",
        // },
        // {
        //     icon: "mdi-receipt-text-outline",
        //     label: "Sales",
        //     path: "/user/auction-finder",
        // },
        // {
        //     icon: "mdi-receipt-text-edit",
        //     label: "Purchase",
        //     path: "/user/auction-finder",
        // },
        // {
        //     icon: "mdi-car-search-outline",
        //     label: "Expense",
        //     path: "/user/auction-finder",
        // },
        //  {
        //     icon: "mdi-file-chart",
        //     label: "Reports",
        //     path: "/user/auction-finder",
        //     chiildren: [
        //         {
        //             label: "Ledger Report",
        //         },    
        //     ]
        // },
        // {
        //     icon: "mdi-cog-outline",
        //     label: "Settings",
        //     path: "/user/settings/profile",
        // },
    ];