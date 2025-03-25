import {useEffect, useState} from 'react';
import { Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem } from '@/types';
import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net-dt/js/dataTables.dataTables.js';

import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

export default function Index() {
    const { categories } = usePage().props;
    const [data, setData] = useState([])
    useEffect(() => {
        setData(categories);
    }, [categories]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categories" />
            <div className={'container'}>
                <div className="overflow-x-auto">
                    <DataTable value={data} tableStyle={{ minWidth: '50rem' }}>
                        <Column field="id" header="ID"></Column>
                        <Column field="name" header="Name"></Column>
                    </DataTable>
                </div>
            </div>
        </AppLayout>
    );
}
