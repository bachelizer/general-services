import generalServicesClient from '../generalServicesClient';

const fetchInventory = () => generalServicesClient.get('/inventory');

const createInventory = payload => generalServicesClient.post('/inventory', payload);

const replenishInventory = (payload, id) =>
  generalServicesClient.put(`/inventory/replenish/${id}`, payload);

const despenseInventory = (payload, id) => generalServicesClient.put(`/inventory/despense/${id}`, payload);


export default {
  fetchInventory,
  createInventory,
  replenishInventory,
  despenseInventory,
};
