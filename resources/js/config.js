import axios from "axios";

const customAxios = axios.create({
    baseURL: import.meta.env.VITE_API_URL
});

export { customAxios };