import generalServicesClient from '../generalServicesClient';

const fetchRole = () => generalServicesClient.get('/roles');

export default {
  fetchRole,
};
