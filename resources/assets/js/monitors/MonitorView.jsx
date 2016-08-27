
import {observer} from "mobx-react";
import React from 'react';
import {RadialBarChart, RadialBar} from 'recharts';

const MonitorView = observer(({item}) => {
    let data = JSON.parse(item.data);
    data.value = 35;
    let array = [data];
    return (
        <div className="col-sm-6 col-md-3">
            <div className="box box-solid box-primary">
                <div className="box-header">
                    <h3 className="box-title">{data.description}</h3>
                </div>
                <div className="box-body">
                    <p>Min.: {data.min}, Max.: {data.max}</p>
                    <RadialBarChart innerRadius={20} outerRadius={140} barSize={30} data={array}>
                        <RadialBar minAngle={15} label background clockWise={true} />
                    </RadialBarChart>
                </div>
            </div>
        </div>
    );
});

export default MonitorView;
