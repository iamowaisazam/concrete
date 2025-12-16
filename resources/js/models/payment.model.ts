import api from "@/plugins/axios";
import { toFormData } from "@/plugins/hleper";
import { errorHandler } from "@/services/responseHandleService";


export default class {


     static async all(options:any) {
        
        try {
            const res = await api.get("/api/payments",{
                params:options
            });
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async find(options:any) {
        
        try {
            const res = await api.get("/api/payments/"+options.id,options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async create(options:any) {

        try {
            const res = await api.post("/api/payments",options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


static async update(id: number | string, options: any) {
    try {

        let req = await toFormData(options);
        req.append("_method","put");

        const res = await api.post(`/api/payments/${id}`, options);
        return res.data;

    } catch (error) {
        throw await errorHandler(error);
    }
}

static async delete(id){
    try{
          const res = await api.delete(`/api/payments/${id}`);
        return res.data;

    }
    catch(error){
        throw await errorHandler(error);
    }
}




}
