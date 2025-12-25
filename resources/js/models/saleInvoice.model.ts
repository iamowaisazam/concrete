import api from "@/plugins/axios";
import { toFormData } from "@/plugins/hleper";
import { errorHandler } from "@/services/responseHandleService";

export default class     {


     static async all(options:any) {
        
        try {
            const res = await api.get("/api/saleInvoice",{
                params:options
            });
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async find(id: number | string) {
        try {
            const res = await api.get(`/api/saleInvoice/${id}`);
            return res.data;
        } catch (error) {
            throw await errorHandler(error);
        }
    }



    static async create(formData: any) {
        try {
        const res = await api.post(
            "/api/saleInvoice",
            formData,
            {
            headers: {
                "Content-Type": "multipart/form-data",
            },
            }
        );
        return res.data;
        } catch (error) {
        throw await errorHandler(error);
        }
    }


static async update(id: number | string, formData: FormData) {
    try {
        formData.append("_method", "PUT");

        const res = await api.post(`/api/saleInvoice/${id}`, formData);
        return res.data;

    } catch (error) {
        throw await errorHandler(error);
    }
}

static async delete(id){
    try{
          const res = await api.delete(`/api/saleInvoice/${id}`);
        return res.data;

    }
    catch(error){
        throw await errorHandler(error);
    }
}




}
