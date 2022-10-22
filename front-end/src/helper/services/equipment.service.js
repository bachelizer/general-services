import generalServicesClient from '../generalServicesClient';

// service for equipment and office-equipments

const fetchEquipment = () => generalServicesClient.get('/equipments');

const fetchOfficeEquipment = () => generalServicesClient.get('/office-equipments');

const createEquipment = payload => generalServicesClient.post('/equipments', payload);

const creatOfficeEquipment = payload => generalServicesClient.post('/office-equipments', payload);

const officeEquipmentMaintenanceNotification = () => generalServicesClient.get('/office-equipment-maintenance-notification');

const officeEquipmentRegularMaintenance = (payload, id) => generalServicesClient.put(`office-equipments/regular-maintenace/${id}`, payload);

export default {
  fetchEquipment,
  fetchOfficeEquipment,
  createEquipment,
  creatOfficeEquipment,
  officeEquipmentMaintenanceNotification,
  officeEquipmentRegularMaintenance,
};
