import { combineReducers } from 'redux';
import EventsReducer from './events.reducer';

const rootReducer = combineReducers({
  wpevents: EventsReducer,
});

export default rootReducer;
