import axios from 'axios';

// return axiosInstance;
const data = parsedUrl => {
  if (parsedUrl === 'http://localhost:8080') {
    return 'http://127.0.0.1:8000/api/';
  }
  if (parsedUrl === '') {
    return '';
  }

  return null;
};

export default axios.create({
  // baseURL: "https://scholarship.asscat.systems/api-main",
  baseURL: data(window.location.origin),
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
  },
  credentials: 'include',
});
