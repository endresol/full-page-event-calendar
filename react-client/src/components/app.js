import React, { Component } from 'react';

import CalenderHeader from './CalenderHeader';
import CalenderComponent from './CalenderComponent';

export default class App extends Component {
  render() {
    return (
      <div>
        <CalenderHeader />
        <CalenderComponent />
      </div>
    );
  }
}
