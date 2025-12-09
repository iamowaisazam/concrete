import axios from 'axios'

// ✅ Create Axios instance
const api = axios.create({
    baseURL: `${import.meta.env.VITE_API_BASE_URL}`, // default /api if not set
    withCredentials: true, // optional if you’re using Laravel Sanctum
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
})

// ✅ Optional: Interceptors for auth token, errors, etc.
api.interceptors.request.use((config) => {
    // Example: Add token from localStorage
    // const token = localStorage.getItem('token')
    // if (token) config.headers.Authorization = `Bearer ${token}`
    return config
})

const token = localStorage.getItem("auth_token");
if (token) {
  api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

export default api
