
import {observer} from "mobx-react";
import React from 'react';

const MonitorView = observer(({item}) =>
    <li>
        {item.text}
    </li>
);

export default MonitorView;
