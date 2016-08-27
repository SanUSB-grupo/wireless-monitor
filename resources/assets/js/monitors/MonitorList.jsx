
import { observable, action } from 'mobx';
import { get, post } from 'axios';

export default class MonitorList {
    @observable list = [];
    @observable loading = true;

    constructor() {
        this.fetch();
    }

    @action fetch () {
        get(`/monitor/ajax-list`)
            .then(response => {
                this.list = response.data.list;
                this.loading = false;
            });
    }
}
