import { defineStore } from "pinia";
import api from "../plugins/axios";
import { errorHandler } from "@/services/responseHandleService";
import { toRaw } from "vue";

export const useUserStore = defineStore("user", {
    state: () => ({
        is_logged_in: false,        
        user: {},
        notification: [
            {
                title: "New Message",
                description: "You received a new message from Admin.",
                time: "2 mins ago",
            },
            {
                title: "Payment Successful",
                description: "Your premium plan has been activated.",
                time: "10 mins ago",
            },
            {
                title: "System Update",
                description: "A new system update is available.",
                time: "1 hour ago",
            },
        ],
        loading: false,
        token: localStorage.getItem('auth_token'),
    }),

    getters: {

    },

    actions: {
        // ==============================
        // LOGIN
        // ==============================
        async loginRequest(data){
            try {
                const form = new FormData();
                form.append("email", data.email);
                form.append("password", data.password);
                const res = await api.post("/api/auth/login", form);
                if (!res.data.data.token) {
                    throw new Error("Token Not Found");
                }
                return res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
        // ==============================
        // REGISTER
        // ==============================
        async registerRequest(data){
            try {
                const form = new FormData();
                for (const key in data) {
                    if (!Object.hasOwn(data, key)) continue;
                    form.append(key,data[key]);
                }
                const res = await api.post("/api/auth/register",form);
                return res.data.data;

            } catch (error) {
                throw await errorHandler(error);
            }
        },
        // ==============================
        // GET PROFILE
        // ==============================
        async getProfile(token = null)
        {   
            if (!token) {
                token = localStorage.getItem('auth_token');
            }

            if (!token) {
                throw new Error("Token Not Found");
            }

            try {
                api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
                let res = await api.get('/api/auth/profile');
              
                
                return res.data.data;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
         // ==============================
        // INITIALIZE SESSION
        // ==============================
       async initializeUserSession(token, data) {  
           
           try {
                
                if(!token) {
                    throw new Error("Token Not Found");
                }
               
                api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
                localStorage.setItem("auth_token", token);
                this.user = data;
                this.is_logged_in = true;
                
            } catch (error) {
                throw await errorHandler(error);
           } 
        },
        // ==============================
        // LOGOUT
        // ==============================
        async logOut(token){
            try {
                api.defaults.headers.common["Authorization"] = '';
                localStorage.removeItem("auth_token", token);
                return token;
            } catch (error) {
                throw await errorHandler(error);
            }
        },
       

    },

});
