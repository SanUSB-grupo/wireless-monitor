
import { observable } from 'mobx';

export default class Monitor {
    id = Math.random();
    @observable text = '';
}
