import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ courses }) {
    return (
        <AuthenticatedLayout>
            <Head title="Cours" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Cours</h1>
                        <p className="text-sm text-slate-600">Gestion des cours.</p>
                    </div>
                    <Link href={route('courses.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</Link>
                </div>
                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Nom</th>
                                <th className="text-left px-4 py-3">Code</th>
                                <th className="text-left px-4 py-3">Filière</th>
                                <th className="text-left px-4 py-3">Coefficient</th>
                                <th className="text-left px-4 py-3">Semestre</th>
                                <th className="text-right px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {courses.map((c) => (
                                <tr key={c.id} className="border-t">
                                    <td className="px-4 py-3">{c.nom}</td>
                                    <td className="px-4 py-3">{c.code}</td>
                                    <td className="px-4 py-3">{c.filiere?.nom}</td>
                                    <td className="px-4 py-3">{c.coefficient}</td>
                                    <td className="px-4 py-3">{c.semestre}</td>
                                    <td className="px-4 py-3 text-right">
                                        <Link href={route('courses.edit', c.id)} className="text-slate-700">Éditer</Link>
                                    </td>
                                </tr>
                            ))}
                            {courses.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="6">Aucun cours.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
