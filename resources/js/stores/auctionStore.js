import { defineStore } from "pinia";
import api from "../plugins/axios";

import { errorHandler } from "@/services/responseHandleService";
import { useMasterStore } from "./masterStore";

export const useAuctionStore = defineStore("auction", {
    state: () => ({
        filter: {
            platform: [],
            vehicleType: [], 
            bodyType: [],
            center: [],
            make: [],
            model: [],
            variant: [],

            mileageFrom:'',
            mileageTo:'',

            year: [],
            transmission: [],
            fuelType: [],
            door: [],
            seat: [],
            grade: [],
            v5: [],
            cc: [],
            formerKeeper: [],
            noOfService: [],
            
            search:'',
            length:10,
            sort_by: 'name-asc',
            page:1,
        },
        auctionTab: true,
        sidebar: true,
        data: [],
        total: 0,
        last_page: 10,
        offset:0,
        loading:false,
    }),
    getters:{

    },
    actions: {
        toggleFilter() {
            this.sidebar = !this.sidebar;
        },
        toggleAuctionTab() {
            this.auctionTab = !this.auctionTab;
        },
        ClearFilter() {

            this.filter.platform = [];
            this.filter.vehicleType = []; 
            this.filter.bodyType = [];
            this.filter.center = [];
            this.filter.make = [];
            this.filter.model = [];
            this.filter.variant = [];
           
            this.filter.year = [],
            this.filter.transmission = [];
            this.filter.fuelType = [];
            this.filter.door = [];
            this.filter.seat = [];
            this.filter.grade = [];
            this.filter.cc = [];
            this.filter.formerKeeper  = [];
            this.filter.noOfService = [];
            this.filter.v5 = [];

            this.filter.search = '';
            this.filter.length = 10;
            this.filter.sort_by = 'name-asc';
            this.page = 1;

            this.filter.mileageFrom = '';
            this.filter.mileageTo = '';

            this.getAuctionList();

        },
        async loadSiderBarFilters() { 
           
            const masterStore = useMasterStore();
            masterStore.getVehicleTypes();
            masterStore.getMakes();
            masterStore.getPlatforms();
            masterStore.getAuctionCenter();
            
            masterStore.getYears();
            masterStore.getTransmissions();
            masterStore.getFuelType();
            masterStore.getDoors();
            masterStore.getSeats();
            masterStore.getDates();
            masterStore.getGrades();
            masterStore.getEngineSize();
            
            masterStore.getV5();
            masterStore.getFormerKeepers();
            masterStore.getNoOfServices()

        },
        async getAuctionList() {
            this.loading = true;
            try {

                let res = await api.get('/api/user/auctionList', {
                    params:this.filter
                })

                this.data = res.data.data;
                this.total = res.data.total;
                this.last_page = res.data.last_page;
                this.offset = res.data.offset;
                this.loading = false;
                return res.data;
            } catch (error) {
                this.loading = false;
                throw await errorHandler(error);
            }
        },
        async getAlertList(options) {
            try {
                let res = await api.get('/api/user/userAlertList', {
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
        removeValue(key, value) {
            if (this.loading) {
                return false; 
            }
              const masterStore = useMasterStore();
            
            switch (key) {

                case 'make':

                    this.filter[key] = this.filter[key].filter(item => item !== value);
                    
                    this.filter.variant = []; 
                    masterStore.variants.data = [];

                    this.filter.model = []; 
                    masterStore.models.data = [];
                    
                    if (this.filter.make.length > 0) {
                          masterStore.getModels({make:this.filter.make});
                    } 
                  
                    this.getAuctionList();
                case 'model':

                  
                    this.filter[key] = this.filter[key].filter(item => item !== value);
                    
                    this.filter.variant = []; 
                    masterStore.variants.data = [];
                    
                    if (this.filter.model.length > 0) {
                          masterStore.getVariants({model:this.filter.model});
                    } 
                  
                    this.getAuctionList();
                    break;
                default:
                    this.filter[key] = this.filter[key].filter(item => item !== value);
                    this.getAuctionList();
                break;
            }
        },

    },

});
