import generalServicesClient from '../generalServicesClient';

const fetchOutsources = () => generalServicesClient.get('/outsource');

const createOutsource = payload => generalServicesClient.post('/outsource', payload);

export default { fetchOutsources, createOutsource };
