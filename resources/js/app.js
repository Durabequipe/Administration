import './bootstrap';

import Alpine from 'alpinejs';

import {ds} from './dragselect';

window.Alpine = Alpine;

Alpine.start();

window.ds = ds;
