import api from "@/plugins/axios";
import { toFormData } from "@/plugins/hleper";
import { errorHandler } from "@/services/responseHandleService";

export default class     {


     static async all(options:any) {
        
        try {
            const res = await api.get("/api/category",{
                params:options
            });
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async find(options:any) {
        
        try {
            const res = await api.get("/api/category/"+options.id,options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async create(options:any) {

        try {
            const res = await api.post("/api/category",options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


static async update(id: number | string, formData: FormData) {
    try {
        formData.append("_method", "PUT");

        const res = await api.post(`/api/category/${id}`, formData);
        return res.data;

    } catch (error) {
        throw await errorHandler(error);
    }
}

static async delete(id){
    try{
          const res = await api.delete(`/api/category/${id}`);
        return res.data;

    }
    catch(error){
        throw await errorHandler(error);
    }
}




}
