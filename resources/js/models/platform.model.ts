import api from "@/plugins/axios";
import { errorHandler } from "@/services/responseHandleService";


export default class Platform {

    
    /**
     * Fetches the Get All.
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
                const res = await api.get("/api/master/getAuctionHouse", { params: options });
                return res.data;
            } catch (e) {
                throw await errorHandler(e);
            }

    }
    
    
}
