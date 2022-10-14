import generalServicesClient from '../generalServicesClient';

const fetchOffice = () => generalServicesClient.get('/offices');
const createOffice = (payload) => generalServicesClient.post('/offices', payload);

const fetchOfficeEquipments = () => generalServicesClient.get('/office-equipment'); // fetch equipments per office

export default { fetchOffice, createOffice, fetchOfficeEquipments };
