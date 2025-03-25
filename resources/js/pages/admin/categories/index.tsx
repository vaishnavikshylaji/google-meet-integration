import { useEffect } from 'react';
import { Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem } from '@/types';
import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net-dt/js/dataTables.dataTables.js';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

export default function Index() {
    const { categories } = usePage().props;
    useEffect(() => {
        $('#categories-table').DataTable({
            data: categories,
            columns: [
                { data: 'id', title: 'ID' },
                { data: 'name', title: 'Name' }
            ],
        });
    }, [categories]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categories" />
            <div className={'container'}>
                <div className="overflow-x-auto">
                    <table id="categories-table" className="display">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
