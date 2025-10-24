import axios from 'axios';

const api = axios.create({
  baseURL: '/api', // ✅ Usa baseURL relativa
  timeout: 15000,
});

export const empresasService = {
  buscar: (params = {}) => api.get('/empresas', { params })
};

export default api;