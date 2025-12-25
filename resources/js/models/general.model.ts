import api from "@/plugins/axios";
import { toFormData } from "@/plugins/hleper";
import { errorHandler } from "@/services/responseHandleService";

export default class     {


    static async get(url:string,options:any) {
        
        try {
            const res = await api.get(url,{
                params:options
            });
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }

    static async all(url: string, filter: any = {}) {
            try {
            const params = {
                page: filter.page || 1,
                length: filter.length || 50,
                search: filter.search || "",
                ...filter,
            };

            const res = await api.get(url, { params });
            return {
                data: res.data.data || [],
                total: res.data.total || 0,
                page: res.data.page || 1,
                last_page: res.data.last_page || 1,
                offset: res.data.offset || 0,
            };
            } catch (error) {
            throw await errorHandler(error);
            }
        }

    static async find(url: string, id: number | string) {
        try {
            const res = await api.get(`${url}/${id}`);
            return res.data;
        } catch (error) {
            throw await errorHandler(error);
        }
    }

    static async post(url,options:any) {
        try {

           let req = await toFormData(options);
            const res = await api.post(url, req);
            return res.data;
    
        } catch (error) {
            throw await errorHandler(error);
        }
    }


    static async put(url:any,options:any) {
        try {

           let req = await toFormData(options);
            req.append("_method","put");
            const res = await api.post(url, req);
            return res.data;
    
        } catch (error) {
            throw await errorHandler(error);
        }
    }


      static async delete(url:any) {
        try {
            const res = await api.delete(url);
            return res.data;
    
        } catch (error) {
            throw await errorHandler(error);
        }
    }



 


}
