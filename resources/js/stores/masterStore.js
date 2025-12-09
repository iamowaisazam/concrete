import { defineStore } from "pinia";
import api from "../plugins/axios";

import { errorHandler } from "@/services/responseHandleService";

export const useMasterStore = defineStore("master", {
    state: () => ({
        platforms: {
            data: [],
            loading:false,
        },
        vehicleTypes: {
            data: [],
            loading:false,
        }, 
        bodyTypes: {
            data: [],
            loading:false,
            
        },
        centers: {
            data: [],
            loading:false,
        },
        makes: {
            data: [],
            loading:false,
        },
        models: {
            data: [],
            loading:false,
        },
        variants: {
            data: [],
            loading:false,
        },
        years: {
            data: [],
            loading:false,
        },
        transmissions: {
            data: [],
            loading:false,
        },
        fuelType: {
            data: [],
            loading:false,
        },
        grades: {
            data: [],
            loading:false,
        },
        v5: {
            data: [],
            loading:false,
        },
        cc: {
            data: [],
            loading:false,
        },
        formerKeepers: {
            data: [],
            loading:false,
        },
        noOfServices: {
            data: [],
            loading:false,
        },
        doors: {
            data: [],
            loading:false,
        },
        seats: {
            data: [],
            loading:false,
        },
        mileage: {
            data: [],
            loading:false,
        },
        dates: {
            data: [],
            loading:false,
        },

    }),
    getters:{

    },
    actions: {
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
        async getPlatforms(options = {}) {
            try {
                let res = await api.get('/api/master/getAuctionHouse',{
                    params:options,
                })
                this.platforms.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getVehicleTypes(options = {}) {
            try {
                let res = await api.get('/api/master/getVehicleTypes',{
                    params:options,
                })
                this.vehicleTypes.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getBodyTypes(options = {}) {
            try {
                let res = await api.get('/api/master/getBodyTypes',{
                    params:options,
                })
                this.bodyTypes.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getAuctionCenter(options = {}) {
            try {
                let res = await api.get('/api/master/getAuctionCenter',{
                    params:options,
                })
                this.centers.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getMakes(options = {}) {
            try {
                let res = await api.get('/api/master/getMakes',{
                    params:options,
                })
                this.makes.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getModels(options = {}) {
            try {
                let res = await api.get('/api/master/getModels',{
                    params:options,
                })
                this.models.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getVariants(options = {}) {
            try {
                let res = await api.get('/api/master/getVariants',{
                    params: options,
                })
                this.variants.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getYears(options = {}) {
            try {
                let res = await api.get('/api/master/getYears',{
                    params: options,
                })
                this.years.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getTransmissions(options = {}) {
            try {
                let res = await api.get('/api/master/getTransmissions',{
                    params: options,
                })
                this.transmissions.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getFuelType(options = {}) {
            try {
                let res = await api.get('/api/master/getFuelType',{
                    params: options,
                })
                this.fuelType.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
         async getDoors(options = {}) {
            try {
                let res = await api.get('/api/master/getDoors',{
                    params: options,
                })
                this.doors.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getSeats(options = {}) {
            try {
                let res = await api.get('/api/master/getSeats',{
                    params: options,
                })
                
                this.seats.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getDates(options = {}) {
            try {
                let res = await api.get('/api/master/getDates',{
                    params: options,
                })
                this.dates.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getGrades(options = {}) {
            try {
                let res = await api.get('/api/master/getGrade',{
                    params: options,
                })
                this.grades.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },

        async getEngineSize(options = {}) {
            try {
                let res = await api.get('/api/master/getEngineSize',{
                    params: options,
                })
                this.cc.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getV5(options = {}) {
            try {
                let res = await api.get('/api/master/getV5',{
                    params: options,
                })
                this.v5.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getNoOfServices(options = {}) {
            
            try {
                let res = await api.get('/api/master/getNoOfServices',{
                    params: options,
                })
                this.noOfServices.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        async getFormerKeepers(options = {}) {
            
            try {
                let res = await api.get('/api/master/getFormerKeepers',{
                    params: options,
                })
                this.formerKeepers.data = res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },

        

        

        
          
          
         
         

        

        
    },

});
