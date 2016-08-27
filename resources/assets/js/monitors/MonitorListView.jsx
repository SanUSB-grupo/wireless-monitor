
import React, {Component} from 'react';
import {observer} from "mobx-react";
import MonitorView from './MonitorView.jsx';

@observer
export default class MonitorListView extends Component {
    render() {
        return (
            <div className="row">
                {this.props.store.loading ? 'Carregando ...' : ''}
                {this.props.store.list.map(item =>
                    <MonitorView item={item} key={item.id} />
                )}
            </div>
        );
    }
}
