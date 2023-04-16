const spliceLongString = (text, count) => {
  return text.slice(0, count) + (text.length > count ? '...' : '');
};

//
const filterData = async (officeId, array) => {
  if (officeId === 1) {
    return array;
  }
  return array.filter(x => x.borrower_office_id === officeId);
};

const filterDataServices = async (officeId, array) => {
  if (officeId === 1) {
    return array;
  }
  return array.filter(x => x.office.id === officeId);
};

const filterConsentBorrowa = async (array) => {
  return array.filter(x => x.approval_status === 'Consent')
}

export default {
  spliceLongString,
  filterData,
  filterConsentBorrowa,
  filterDataServices,
};
