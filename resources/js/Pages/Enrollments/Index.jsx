import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ enrollments }) {
    return (
        <AuthenticatedLayout>
            <Head title="Inscriptions" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Inscriptions</h1>
                        <p className="text-sm text-slate-600">Lier un étudiant à une filière.</p>
                    </div>
                    <Link href={route('enrollments.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</Link>
                </div>
                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Étudiant</th>
                                <th className="text-left px-4 py-3">Filière</th>
                                <th className="text-left px-4 py-3">Année</th>
                            </tr>
                        </thead>
                        <tbody>
                            {enrollments.map((e) => (
                                <tr key={e.id} className="border-t">
                                    <td className="px-4 py-3">{e.student?.nom} {e.student?.prenom}</td>
                                    <td className="px-4 py-3">{e.filiere?.nom}</td>
                                    <td className="px-4 py-3">{e.annee_academique}</td>
                                </tr>
                            ))}
                            {enrollments.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="3">Aucune inscription.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
