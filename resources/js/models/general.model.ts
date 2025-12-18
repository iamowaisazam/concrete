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
