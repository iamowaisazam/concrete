import api from "@/plugins/axios";
import _ from "lodash";
import { errorHandler } from "@/services/responseHandleService";



/**
 * Fetches the re-auction list for a user.
 */

export async function reAuctionList(options: {
    reg?: string;
    year?: string;
    search?: string;
    page?: number;
    length?: number;

}): Promise<{
    data: unknown[];
    centers: unknown[];
    platforms: unknown[];
    recordsFiltered: number;
    recordsTotal: number;
    page: number;
    length: number;
    last_page: number;
    offset: number;
}> {

    try {
        const res = await api.get("/api/user/reAuctionList", { params: options });
        return res.data;
    } catch (e) {
        throw await errorHandler(e);
    }

}



/**
 * Fetches the re-auction list for a user.
 */

    export async function auctionSheldulerList(options: {
        platform_id?: number;
        center_id?: number;
        current?: string;
        date?: string;
        search?: string;
        page?: number;
        length?: number;

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
            const res = await api.get("/api/user/auctionShedule", { params: options });
            return res.data;
        } catch (e) {
            throw await errorHandler(e);
        }

    }




export default {
    reAuctionList,
    auctionSheldulerList
}