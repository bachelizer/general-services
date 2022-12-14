const spliceLongString = (text, count) => {
  return text.slice(0, count) + (text.length > count ? '...' : '');
};

//
const filterData = async (officeId, array) => {
  if (officeId === 1) {
    return array;
  }
  return array.filter(x => x.office_id === officeId);
};

export default {
  spliceLongString,
  filterData,
};
