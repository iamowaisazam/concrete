import { defineStore } from "pinia";
import api from "../plugins/axios";

import { errorHandler } from "@/services/responseHandleService";

import Vehicle from '@/models/vehicle.model';

export const useVehicleStore = defineStore("vehicle", {
    state: () => ({
        sidebar: true,
        isMobile: false,
        isVehicle: true,
        tab: 'details',
        vehicle: Vehicle.getModelKeys(),
        auctionTab: true,
        platforms: [],
        length: 10,
        sort_by: 'name-asc',
        data: [],
        fuel_type: [],
        relatedVehicle: {
            total: 18,
            per_page: 10,
            current_page: 1,
            last_page: 2,
            data: [],
        },
        overView: {
            title: 'ABARTH 595 1.4 T-JET 165 TURISMO Hatchback',
            images: [
                "https://bcamediaprod.blob.core.windows.net/public/images/vehicle/GB/OV21FFE/610237700/600",
                "https://www1.bcaimage.com/Document?DocType=VehicleImage&width=600&docId=610237703",
                "https://www1.bcaimage.com/Document?DocType=VehicleImage&width=600&docId=610232526",
                "https://www1.bcaimage.com/Document?DocType=VehicleImage&width=600&docId=610237708",
            ],
            vehicleType: 'Car',
            make: 'BMW',
            model: '3 Series',
            variant: '330e',
            cc: '2.0',
            year: '2022',
            color: 'red',
            fuelType: 'Hybrid',
            transmission: 'Automatic',
            keys: '2',
            doors: '4',
            seats: '4',
            reg: 'RO70 VDP',
            dor: '2020 (70 reg)',
            mileage: '300',
            grade: '5',
            v5: 'Not Present',
            inspection: '',
            biddingStatus: 'Sold',

            lot: 'MC103',
            previousAuction: '',
            auctionType: 'Online Auction',
            dateTime: '2025-10-18 14:34:04',
            auction: {
                title: 'Central Car Auctions'
            },
            center: {
                title: 'Bedford',
            },
            disclaimer: 'AUTOBILI LTD aggregates vehicle auction data from third-party sources providing it as-is to help users make informed decisions, without guaranteeing data accuracy or completeness. learn more',

            // Additional Info
            formerKeepers: 1,
            vendors: 2,
            vatType: 'No',
            euroStatus: 'No',
            engineRuns: 'No',

            // Service
            serviceReport: "ecuHeldServiceHistory",
            noOfServices: 2,
            lastService: "2025-04-15",
            lastServiceMileage: 44812,
            serviceNotes: "123",
            dvsaMileage: "na",
            motExpiryDate: "2025-07-28",
            motDue: "MOT DUE",

            //
            equipments: [
                'Charge Cable - 3 Pin',
                'Charge Cable - Type 2',
                'Navigation HDD',
                'Parking Assistance Pack',
                'Hi-Fi Speaker System - 10',
                'Navigation HDD',
                'Parking Assistance Pack',
                'Climate Control', 'Cloth Trim - Anthracite', 'Tyre Repair Kit'
            ]

        }
    }),
    getters: {
         

    },
    actions: {
        toggleFilter() {
            this.vehichleDetail.sidebar = !this.vehichleDetail.sidebar
        },
        toggleAuctionTab() {
            this.auctionTab = !this.auctionTab
        },
    
        async getreAuctionList(options) {
            try {
                let res = await api.get('/api/user/reAuctionList', {
                    params: {
                        length: options.length,
                        search: options.search
                    },
                })
                return res.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },

    },

});
