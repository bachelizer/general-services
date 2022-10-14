import generalServicesClient from '../generalServicesClient';

const fetchBorrows = () => generalServicesClient.get('/borrows');

const postBorrows = payload => generalServicesClient.post('/borrows', payload);

const approveBorrow = ([payload, id]) =>
  generalServicesClient.put(`/borrows/approve/${id}`, payload);

const rejectBorrow = ([payload, id]) => generalServicesClient.put(`/borrows/reject/${id}`, payload);

const returnBorrow = id => generalServicesClient.put(`/borrows/return/${id}`);

const borrowReport = payload =>
  generalServicesClient.get(`/borrows/report/${payload.startDate}/${payload.endDate}`, payload);

const printForm = payload => generalServicesClient.get(`/borrows/report/generate-pdf?id=${payload.id}`);

export default {
  fetchBorrows,
  postBorrows,
  approveBorrow,
  rejectBorrow,
  returnBorrow,
  borrowReport,
  printForm,
};
