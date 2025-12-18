import api from "@/plugins/axios";
import { toFormData } from "@/plugins/hleper";
import { errorHandler } from "@/services/responseHandleService";

export default class     {


    static async all(options:any) {
        
        try {
            const res = await api.get("/api/reports/customerLedger",{
                params:options
            });
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }
    static async ledger(id: number | string) {
        try {
            const res = await api.get(`/api/reports/customerLedgerDetail/${id}`);
            return res.data;
        } catch (error) {
            throw await errorHandler(error);
        }
    }




}
