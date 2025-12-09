import { defineStore } from "pinia";
import _ from 'lodash';
import pageService from "@/services/pageService";


export const usePageStore = defineStore("page", {
    state: () => ({
        reauction: {
            reg: '',
            year: null,
            length: 10,
            page: 1,
            offset: 0,
            data: [],
            total: 0,
            offset:0,
            last_page:1,
            loading:false,
        },
        recentDevices: {
            length: 10,
            page: 1,
            offset: 0,
            data: [
                {
                 platform:'Windows',
                 browser:'Chrome',
                 device:'Desktop',
                 location:'Not found',
                 recent_activities:'21, November 2025 11:35'   
                },
                {
                 platform:'Windows',
                 browser:'Chrome',
                 device:'Desktop',
                 location:'Not found',
                 recent_activities:'21, November 2025 11:35'   
                }
            ],
            total: 0,
            offset:0,
            last_page:1,
            loading:false,
            headers: [
                { title: "Platform", key: "platform" },
                { title: "Browser", value: "browser" },
                { title: "Device", value: "device" },
                { title: "Location", value: "location" },
                { title: "Recent Activities", key: "recent_activities" },
            ],
        },

        //
        //  AuctionShedule__________________
        //
        auctionShedule: {
           
        },
        billingHistory: {
            length: 10,
            page: 1,
            offset: 0,
            data: [
                {
                "id": 1,
                "date": "21, November 2025",
                "plan": "Ulta",
                "start": "21 Nov 2025",
                "expiry": "21 Dec 2025",
                "amount": "$100.00",
                "status": "Active",
                "invoice": "Download"
                },
                {
                "id": 2,
                "date": "15, October 2025",
                "plan": "Plus",
                "start": "15 Oct 2025",
                "expiry": "15 Nov 2025",
                "amount": "$50.00",
                "status": "Expired",
                "invoice": "Download"
                },
                {
                "id": 3,
                "date": "01, September 2025",
                "plan": "Entry",
                "start": "01 Sep 2025",
                "expiry": "01 Oct 2025",
                "amount": "$30.00",
                "status": "Cancelled",
                "invoice": "Download"
                },
            ],
            total: 0,
            offset:0,
            last_page:1,
            loading:false,
            headers: [
                { title: "Id", key: "id" },
                { title: "Date", value: "date" },
                { title: "Plan Name", value: "plan" },
                { title: "Start", value: "start" },
                { title: "Expiry", value: "expiry" },
                { title: "Amount", value: "amount" },
                { title: "Status", value: "status" },
                { title: "Invoice", value: "invoice" },
            ],
        },
    }),
    getters:{

    },
    actions: {
        async getreAuctionList() {

            try {

                this.reauction.loading = true;
                const res = await pageService.reAuctionList(_.pick(this.reauction, ['reg', 'year', 'page','length']))
                this.reauction.data = res.data || [];
                this.reauction.total = res.recordsTotal;
                this.reauction.offset = res.offset;
                this.reauction.page = res.page;
                this.reauction.last_page = res.last_page;
                this.reauction.loading = false;

                // return res.data;
            } catch (error) {
                alert(error)
                  this.reauction.loading = false;
            }
        },  
        


    },

});
