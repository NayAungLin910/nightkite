import axios from "axios";

const customAxios = axios.create({
    baseURL: "https://nightkite.link/api/"
});

export { customAxios };