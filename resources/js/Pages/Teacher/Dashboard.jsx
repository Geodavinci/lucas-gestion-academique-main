import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard({ teacher }) {
    return (
        <AuthenticatedLayout>
            <Head title="Dashboard enseignant" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Dashboard enseignant</h1>
                        <p className="text-sm text-slate-600">Mes cours et saisie des notes.</p>
                    </div>
                </div>

                {!teacher && (
                    <div className="rounded border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
                        Aucun profil enseignant lié à ce compte.
                    </div>
                )}

                {teacher && (
                    <div className="bg-white rounded border border-slate-200">
                        <table className="w-full text-sm">
                            <thead className="bg-slate-50 text-slate-600">
                                <tr>
                                    <th className="text-left px-4 py-3">Cours</th>
                                    <th className="text-left px-4 py-3">Filière</th>
                                    <th className="text-left px-4 py-3">Code</th>
                                    <th className="text-right px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {teacher.courses?.map((c) => (
                                    <tr key={c.id} className="border-t">
                                        <td className="px-4 py-3">{c.nom}</td>
                                        <td className="px-4 py-3">{c.filiere?.nom}</td>
                                        <td className="px-4 py-3">{c.code}</td>
                                        <td className="px-4 py-3 text-right">
                                            <Link href={route('grades.create', c.id)} className="text-slate-700">Saisir notes</Link>
                                        </td>
                                    </tr>
                                ))}
                                {(!teacher.courses || teacher.courses.length === 0) && (
                                    <tr className="border-t">
                                        <td className="px-4 py-6 text-center text-slate-500" colSpan="4">Aucun cours assigné.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
