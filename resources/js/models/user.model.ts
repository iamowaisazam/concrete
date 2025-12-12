import api from "@/plugins/axios";
import { toFormData } from "@/plugins/hleper";
import { errorHandler } from "@/services/responseHandleService";

export default class UserModel {


     static async all(options:any) {
        
        try {
            const res = await api.get("/api/users",{
                params:options
            });
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async find(options:any) {
        
        try {
            const res = await api.get("/api/users/"+options.id,options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async create(options:any) {

        try {
            const res = await api.post("/api/users",options);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }


    static async update(options:any) {

        
        let req = await toFormData(options);

        req.append("_method","put");
        try {
            const res = await api.post("/api/users/"+options.id,req);
            return res.data;
        
        } catch (error) {
            throw await errorHandler(error);
        }

    }



}
