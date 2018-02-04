
const defaultState = {
  events: [],
  selectedEvent: null,
}

export default function(state = defaultState, action) {
  switch (action.type) {
    case 'SELECT_EVENT':
      return {
        ...state,
        selectedEvent: action.payload,
      }
    case 'FETCH_EVENTS': {
      return {
        ...state,
        events: action.payload.data,
      }
    }
  };
  return state;
}
