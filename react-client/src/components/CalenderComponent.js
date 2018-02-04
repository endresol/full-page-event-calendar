import React, { Component } from 'react';
import { connect } from 'react-redux';
import { selectEvent } from '../actions/index';

class CalenderComponent extends Component {
  renderList() {
    return this.props.events.map((event) => {
        return (
          <li
            key={event.post_name}
            onClick={() => this.props.dispatchSelectEvent(event)}
            className="list-group-item">
            {event.post_name}
            </li>
        )
    });
  }

  render() {
    console.log('events', this.props.events);

    if (!this.props.events) {
      return <div>loading</div>;
    }
    return (
      <ul className="list-group col-sm-4">
        {this.renderList()}
      </ul>
    );
  }
};

const mapStateToProps = (state) => {
  return {
    events: state.wpevents.events,
  };
}

const mapDispatchToProps = (dispatch) => {
  return {
    dispatchSelectEvent: (event) => {dispatch(selectEvent(event))},
  }
  // return bindActionCreators({selectEvent: selectEvent}, dispatch);
}

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(CalenderComponent)
