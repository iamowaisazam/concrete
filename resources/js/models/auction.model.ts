import api from "@/plugins/axios";
import { errorHandler } from "@/services/responseHandleService";


export default class Auction {

    
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
                const res = await api.get("/api/master/auctionList", { params: options });
                return res.data;
            } catch (e) {
                throw await errorHandler(e);
            }

    }
    


    
    /**
     * Fetches the Models.
     */
       static async getYears(options: {
        
        }): Promise<{
            data: unknown[];
        }> {

            try {
                const res = await api.get("/api/master/getYears", { params: options });
                return res.data;
            } catch (e) {
                throw await errorHandler(e);
            }

    }


    
}
