import api from "@/plugins/axios";
import _ from "lodash";
import { errorHandler } from "@/services/responseHandleService";



/**
 * Fetches the Makes list for a user.
 */

export async function getProfile(options: {
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



/**
 * Update Profile.
 */
export async function updateProfile(data: Record<string, string | Blob | File>) {
      
    try {
            
            const form = new FormData();
            for (const key in data) {
                if (Object.prototype.hasOwnProperty.call(data, key)) {
                    form.append(key, data[key]);
                }
            }
        
            const res = await api.post("/api/auth/profile",form);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }
}


    /**
     * Update Profile.
     */
    export async function changPassword(options: {
        current_password: string;
        new_password: string;
        new_password_confirmation: string;
    }) {
        
        try {
                const res = await api.post("/api/auth/changePassword",options);
                return res.data;
            
            } catch (error) {
                throw await errorHandler(error);
            }
    }





export default {
    getProfile,
    updateProfile

}