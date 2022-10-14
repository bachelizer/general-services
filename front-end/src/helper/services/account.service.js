import generalServicesClient from '../generalServicesClient';

const createAccount = payload => generalServicesClient.post('/account', payload);

export default {
  createAccount,
};
