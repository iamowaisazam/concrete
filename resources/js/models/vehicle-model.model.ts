import api from "@/plugins/axios";
import { errorHandler } from "@/services/responseHandleService";

export default class Model {


    /**
     * Fetches the Models.
     */
       static async get(options: {
            makes:unknown[],
            search?: string;
            page?: number;
            length?: number;
            id?: number;
        }): Promise<{
            data: unknown[];
            recordsFiltered: number;
            recordsTotal: number;
            page: number;
            length: number;
            last_page: number;
            offset: number;
        }> {

            try {
                const res = await api.get("/api/master/getModels", { params: options });
                return res.data;
            } catch (e) {
                throw await errorHandler(e);
            }

    }
    
    
}
