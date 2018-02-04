import axios from 'axios';
const WP_API_URL = 'http://endre.dev/wp-json/fpec_events/v1/events/';

export const fetchEvents = (year, month) => {
  const url = `${WP_API_URL}${year}/${month}`;
  const request = axios.get(url);

  return {
    type: 'FETCH_EVENTS',
    payload: request,
  };
}

export const selectEvent = (event) => {
  return {
    type: 'SELECT_EVENT',
    payload: event,
  };
}
