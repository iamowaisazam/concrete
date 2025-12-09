import { defineStore } from "pinia";
import api from "../plugins/axios";
import {useThemeStore} from './themeStore';
import { errorHandler } from "@/services/responseHandleService";


export const useInterestStore = defineStore("interest", {
    state: () => ({
    }),

    getters: {

    },

    actions: {
        async getMyInterest(options)
        {   
            try {
                let res = await api.get('/api/user/interest/myInterest',{
                    params: {
                        length: options.length,
                        search:options.search,
                    }
                });
                return res.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
      
    },

});
