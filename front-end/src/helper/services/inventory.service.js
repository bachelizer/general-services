import generalServicesClient from '../generalServicesClient';

const fetchInventory = () => generalServicesClient.get('/inventory');

const createInventory = payload => generalServicesClient.post('/inventory', payload);

export default {
  fetchInventory,
  createInventory,
};
