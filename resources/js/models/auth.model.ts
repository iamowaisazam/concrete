import api from "@/plugins/axios";
import { errorHandler } from "@/services/responseHandleService";

export default class Auth {


    static async getProfile(options: {
        search?: string;
        page?: number;
        length?: number;

    }): Promise<{
        data: unknown[];
    }> {

        try {
            const res = await api.get("/api/auth/profile", { params: options });
            return res.data;
        } catch (e) {
            throw await errorHandler(e);
        }

    }



}
