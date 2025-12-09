export const getMenu = () => {
    return [
        {
            label: "Menu",
            type: "group",
        },
        {
            icon: "mdi-view-dashboard-outline",
            label: "Dashboard",
            path: "/user/dashboard",
            // children: [
            //     {
            //         icon: "gavel",
            //         label: "Auction Finder",
            //         path: "/auction-finder",
            //     },
            //     {
            //         icon: "gavel",
            //         label: "Auction Finder",
            //         path: "/auction-finder",
            //     },
            //     {
            //         icon: "gavel",
            //         label: "Auction Finder",
            //         path: "/auction-finder",
            //     },
            // ]
        },
        {
            icon: "mdi-car-search-outline",
            label: "Auction Finder",
            path: "/user/auction-finder",
        },
        // {
        //     icon: "mdi-thumb-up",
        //     label: "My Interest",
        //     path: "/user/interest",
        // },
        {
            icon: "mdi-history",
            label: "Watchlist",
            path: "/user/watchlist",
        },
        {
            icon: "mdi-calendar-sync-outline",
            label: "Reauction",
            path: "/user/reauction",
        },
        // {
        //     icon: "mdi-compare-horizontal",
        //     label: "Compare",
        //     path: "/user/compare",
        // },
        {
            icon: "mdi-calendar-check-outline",
            label: "Auction Schedule",
            path: "/user/auctionscheduler",
        },
        {
            label: "Profile",
            type: "group",
        },
        // {
        //     icon: "mdi-face-agent",
        //     label: "Support",
        //     path: "/user/support",
        // },
        // {
        //     icon: "mdi-newspaper",
        //     label: "News",
        //     path: "/user/news",
        // },
        {
            icon: "mdi-account-outline",
            label: "Profile",
            path: "/user/profile",
        },
        {
            icon: "mdi-cog-outline",
            label: "Settings",
            path: "/user/settings/profile",
        },
    ];
};

export default {
    getMenu,
};
