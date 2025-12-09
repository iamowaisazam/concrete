import api from "@/plugins/axios";
import { errorHandler } from "@/services/responseHandleService";

export default class UserModel {


    // -------------------------------
    // 1. Field definitions (like $fillable)
    // -------------------------------
    static fields = [
        // Personal
        { icon: 'mdi-account',key: "firstName", label: "First Name", type: "text", group: "personal" },
        { icon: 'mdi-web',key: "surname", label: "Surname", type: "text", group: "personal" },
        { icon: 'mdi-web',key: "jobTitle", label: "Job Title", type: "text", group: "personal" },
        { icon: 'mdi-web',key: "avatar", label: "Avatar", type: "file", accept: "image/*", group: "personal" , placeholder:'Avatar Allowed JPG, GIF or PNG. Max size of 800K' },
        { icon: 'mdi-phone',key: "phone", label: "Phone", type: "text", group: "personal" },
        { icon: 'mdi-email-outline',key: "personalEmail", label: "Personal Email", type: "email", group: "personal" },

        // Business Info
        { icon: 'mdi-office-building', key: "companyName", label: "Company Name", type: "text", group: "bussiness" },
        { icon: 'mdi-web', key: "businessType", label: "Business Type", type: "text", group: "bussiness" },
        { icon: 'mdi-web', key: "companyReg", label: "Company Reg", type: "text", group: "bussiness" },
        { icon: 'mdi-email-outline', key: "businessEmail", label: "Business Email", type: "email", group: "bussiness" },
        { icon: 'mdi-home-city', key: "country", label: "Country", type: "text", group: "bussiness" },
        { icon: 'mdi-home-city', key: "townCity", label: "Town / City", type: "text", group: "bussiness" },
        { icon: 'mdi-home-city', key: "postcode", label: "Postcode", type: "text", group: "bussiness" },
        { icon: 'mdi-home-city', key: "companyAddress1", label: "Company Address 1", type: "text", group: "bussiness" },
        { icon: 'mdi-home-city', key: "companyAddress2", label: "Company Address 2", type: "text", group: "bussiness" },
        { icon: 'mdi-shield-check', key: "motorTradeInsurance", label: "Motor Trade Insurance", type: "select", group: "bussiness" },
        { icon: 'mdi-card-bulleted-outline', key: "vatNumber", label: "VAT Number", type: "text", group: "bussiness" },
        { icon: 'mdi-phone', key: "telephone", label: "Telephone", type: "text", group: "bussiness" },
        { icon: 'mdi-web', key: "website", label: "Website", type: "text", group: "bussiness" },

        // Proof
        { icon: 'mdi-web',key: "uploadID", label: "Upload ID", type: "file", accept: "image/*,.pdf", group: "proof" },
        { icon: 'mdi-web',key: "motorTradeProof", label: "Motor Trade Proof", type: "file", accept: "image/*,.pdf", group: "proof" },
        { icon: 'mdi-web',key: "addressProof", label: "Address Proof", type: "file", accept: "image/*,.pdf", group: "proof" },
    ];


     static getFields() {
        return { ...this.fields };
    }


    // --------------------------------
    // Get all fields EXCEPT some keys
    // --------------------------------
    static getFieldsExcept(except: string[] = []) {
        return Object.entries(UserModel.fields)
            .filter(([key]) => !except.includes(key))
            .reduce((obj, [key, value]) => {
                obj[key] = value;
                return obj;
            }, {} as Record<string, any>);
    }

       // ---------------------------------------------------
    // ✔ Get only specific fields
    // ---------------------------------------------------
    static getFieldsOnly(keys: string[]) {
        const result: any = {};
        keys.forEach(key => {
            if (this.fields[key]) {
                result[key] = this.fields[key];
            }
        });
        return result;
    }


    // ---------------------------------------------------
    // ✔ Get a single field definition
    // ---------------------------------------------------
    static getField(key: string) {
        return this.fields.find((data) => data.key == key );
    }


    // ---------------------------------------------------
    // ✔ Get a single field definition
    // ---------------------------------------------------
    static groupByFields(group): unknown[] {
      
        return this.fields.filter((res) => res.group == group);
        
    }


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


    static async getWatchList(options: {
        search?: string;
        page?: number;
        length?: number;
        make?: number;
        year?: string;
        reg_search?: number;
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
            let res = await api.get('/api/user/notifications/userWatchList', {
                params:options,
            })
            return res.data;
        } catch (error) {
            throw await errorHandler(error);
        }

    }

   static async supportForm(options:any) {
        
        try {
                const res = await api.post("/api/user/page/supportForm",options);
                return res.data;
            
            } catch (error) {
                throw await errorHandler(error);
            }
    }


}
