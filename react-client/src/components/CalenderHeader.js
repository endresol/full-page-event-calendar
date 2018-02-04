import React, { Component } from 'react';
import { connect } from 'react-redux';

import { fetchEvents } from '../actions/index';

class CalenderHeader extends Component {
  constructor(props) {
    super();
  }

  componentDidMount() {
    this.props.dispatchFetchEvents(2017,3);
  }

  render() {
    return (
      <div>
        <div> &lt; </div>
        <div> Mars </div>
        <div> &gt; </div>
      </div>
    )
  }
}

const mapStateToProps = (state) => {
  return {
    events: state.events,
  };
};

const mapDispatchToProps = (dispatch) => {
  return {
    dispatchFetchEvents: (month, year) => {dispatch(fetchEvents(month, year))},
  }
}

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(CalenderHeader);
