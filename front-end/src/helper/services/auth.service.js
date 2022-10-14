import generalServicesClient from '../generalServicesClient';

const login = (payload) => generalServicesClient.post('/login', payload);

export default {
  login,
};
