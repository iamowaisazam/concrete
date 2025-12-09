import api from "@/plugins/axios";
import { errorHandler } from "@/services/responseHandleService";

export default class Make {


    /**
     * Fetches the Models.
     */
       static async get(options: {
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
                const res = await api.get("/api/master/getMakes", { params: options });
                return res.data;
            } catch (e) {
                throw await errorHandler(e);
            }

    }
    
    
}
