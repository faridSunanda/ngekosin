import $ from 'jquery';
import DataTable from 'datatables.net-dt';
import { createIcons, icons } from 'lucide';

window.$ = window.jQuery = $;
window.DataTable = DataTable;

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});
