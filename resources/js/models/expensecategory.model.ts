import api from "@/plugins/axios";
import { toFormData } from "@/plugins/hleper";
import { errorHandler } from "@/services/responseHandleService";

export default class     {


     static async all(options:any) {
        
        try {
            const res = await api.get("/api/expenseCategory",{
                params:options
            });
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async find(options:any) {
        
        try {
            const res = await api.get("/api/expenseCategory/"+options.id,options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async create(options:any) {

        try {
            const res = await api.post("/api/expenseCategory",options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


static async update(id: number | string, formData: FormData) {
    try {
        formData.append("_method", "PUT");

        const res = await api.post(`/api/expenseCategory/${id}`, formData);
        return res.data;

    } catch (error) {
        throw await errorHandler(error);
    }
}

static async delete(id){
    try{
          const res = await api.delete(`/api/expenseCategory/${id}`);
        return res.data;

    }
    catch(error){
        throw await errorHandler(error);
    }
}




}
