import generalServicesClient from '../generalServicesClient';

const fetchBorrows = () => generalServicesClient.get('/borrows');

const postBorrows = payload => generalServicesClient.post('/borrows', payload);

const approveBorrow = ([payload, id]) =>
  generalServicesClient.put(`/borrows/approve/${id}`, payload);

// forward to OP office for approval
const consentBorrow = ([payload, id]) =>
  generalServicesClient.put(`/borrows/consent/${id}`, payload);

const rejectBorrow = ([payload, id]) => generalServicesClient.put(`/borrows/reject/${id}`, payload);

const returnBorrow = id => generalServicesClient.put(`/borrows/return/${id}`);

const borrowReport = payload =>
  generalServicesClient.get(`/borrows/report/${payload.startDate}/${payload.endDate}`, payload);

const printForm = payload =>
  generalServicesClient.get(`/borrows/report/generate-pdf?id=${payload.id}`);

const getBorrowStatistics = () => generalServicesClient.get('/borrows/statistics');

export default {
  fetchBorrows,
  postBorrows,
  approveBorrow,
  rejectBorrow,
  returnBorrow,
  borrowReport,
  printForm,
  getBorrowStatistics,
  consentBorrow,
};
