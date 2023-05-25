import generalServicesClient from '../generalServicesClient';

const fetchBorrows = () => generalServicesClient.get('/borrows');

const postBorrows = payload => generalServicesClient.post('/borrows', payload);

const approveBorrow = ([payload, id]) =>
  generalServicesClient.put(`/borrows/approve/${id}`, payload);

const processBorrow = id => generalServicesClient.put(`/borrows/process/${id}`);

// forward to OP office for approval
const forwardBorrow = ([payload, id]) =>
  generalServicesClient.put(`/borrows/forward/${id}`, payload);

const rejectBorrow = ([payload, id]) => generalServicesClient.put(`/borrows/reject/${id}`, payload);

const returnBorrow = id => generalServicesClient.put(`/borrows/return/${id}`);

const borrowReport = payload =>
  generalServicesClient.get(`/borrows/report/${payload.startDate}/${payload.endDate}`, payload);

const borrowReportListPdf = payload =>
  generalServicesClient.get(`/borrows/report-pdf/${payload.startDate}/${payload.endDate}`, payload);

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
  forwardBorrow,
  borrowReportListPdf,
  processBorrow,
};
