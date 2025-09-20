// Cliente Axios configurado con baseURL de .env
// import axios from 'axios'

// const api = axios.create({
//   baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
//   timeout: 15000
// })

// export default api


import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
    }
});

export const empresasService = {
    buscar: (params = {}) => api.get('/empresas', { params })
};

export default api;