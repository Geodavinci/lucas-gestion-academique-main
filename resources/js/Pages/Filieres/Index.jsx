import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ filieres }) {
    return (
        <AuthenticatedLayout>
            <Head title="Filières" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Filières</h1>
                        <p className="text-sm text-slate-600">Gestion des filières.</p>
                    </div>
                    <Link href={route('filieres.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</Link>
                </div>
                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Nom</th>
                                <th className="text-left px-4 py-3">Code</th>
                                <th className="text-left px-4 py-3">Cours</th>
                                <th className="text-left px-4 py-3">Inscriptions</th>
                                <th className="text-right px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filieres.map((f) => (
                                <tr key={f.id} className="border-t">
                                    <td className="px-4 py-3">{f.nom}</td>
                                    <td className="px-4 py-3">{f.code}</td>
                                    <td className="px-4 py-3">{f.courses_count}</td>
                                    <td className="px-4 py-3">{f.enrollments_count}</td>
                                    <td className="px-4 py-3 text-right space-x-2">
                                        <Link href={route('filieres.edit', f.id)} className="text-slate-700">Éditer</Link>
                                    </td>
                                </tr>
                            ))}
                            {filieres.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="5">Aucune filière.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
