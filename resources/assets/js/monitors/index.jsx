
import React from 'react';
import ReactDOM from 'react-dom';
import MonitorListView from './MonitorListView.jsx';
import MonitorList from './MonitorList.jsx';
import Monitor from './Monitor.jsx';

const store = new MonitorList();

ReactDOM.render(
    <MonitorListView store={store} />,
    document.getElementById('root-app')
);
