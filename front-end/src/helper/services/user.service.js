import generalServicesClient from '../generalServicesClient';

const users = () => generalServicesClient.get('/users');
const createUsers = (payload) => generalServicesClient.post('/users', payload);
const updateUser = (id, payload) => generalServicesClient.put(`/users/${id}`, payload);
const fetchUserEquipments = (userId) => generalServicesClient.get(`/user-equipments/${userId}`);

export default {
  users,
  createUsers,
  updateUser,
  fetchUserEquipments,
};
