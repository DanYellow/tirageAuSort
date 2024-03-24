import TomSelect from "tom-select";

import './bootstrap.js';

import './styles/app.css';
alert("okk")
document
    .querySelectorAll("select[id^='EloquenceContest_participants_']")
    .forEach((item) => {
        new TomSelect(item, {});
    });
