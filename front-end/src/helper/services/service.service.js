import generalServicesClient from '../generalServicesClient';

// service for maintenance, and service
const fetchMaintenance = () => generalServicesClient.get('/maintenances');

const postMaintenance = data => generalServicesClient.post('/maintenances', data);

const servedMaintenance = (data, id) =>
  generalServicesClient.put(`/maintenances/served/${id}`, data);

const processMaintenance = (id) =>
  generalServicesClient.put(`/maintenances/process/${id}`);

const evaluateMaintenance = (data, id) =>
  generalServicesClient.put(`maintenances/evaluate/${id}`, data);
const fetchServices = () => generalServicesClient.get('/services');

const serviceReport = payload =>
  generalServicesClient.get(
    `/maintenances/report/${payload.startDate}/${payload.endDate}`,
    payload,
  );

const serviceReportListPdf = payload =>
  generalServicesClient.get(
    `/maintenance/report-pdf/${payload.startDate}/${payload.endDate}`
  );

const servicePDF = id => generalServicesClient.get(`/maintenances/report/generate-pdf?id=${id}`);

const getServicesStatistics = () => generalServicesClient.get('/maintenance/statistics');

export default {
  fetchMaintenance,
  fetchServices,
  postMaintenance,
  servedMaintenance,
  evaluateMaintenance,
  serviceReport,
  servicePDF,
  getServicesStatistics,
  serviceReportListPdf,
  processMaintenance,
};
