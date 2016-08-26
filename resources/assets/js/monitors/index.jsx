
import React from 'react';
import ReactDOM from 'react-dom';
import MonitorListView from './MonitorListView.jsx';
import MonitorList from './MonitorList.jsx';
import Monitor from './Monitor.jsx';

const store = new MonitorList();
let item1 = new Monitor();
item1.text = 'temperature laese';
store.list.push(item1);

ReactDOM.render(
    <MonitorListView store={store} />,
    document.getElementById('root-app')
);
