import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function ByStudent({ student, memoires, annee }) {
    const form = useForm({ annee: annee || '' });

    return (
        <AuthenticatedLayout>
            <Head title="Mémoires par étudiant" />
            <div className="mx-auto max-w-5xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Mémoires de {student.nom} {student.prenom}</h1>
                        <p className="text-sm text-slate-600">Filtrer par année.</p>
                    </div>
                    <Link href={route('students.show', student.id)} className="text-sm text-slate-600">Retour</Link>
                </div>

                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.get(route('students.memoires', student.id));
                    }}
                    className="mb-4 flex items-end gap-3"
                >
                    <div>
                        <label className="block text-sm font-medium">Année</label>
                        <input
                            className="mt-1 w-40 rounded border-slate-300"
                            value={form.data.annee}
                            onChange={(e) => form.setData('annee', e.target.value)}
                        />
                    </div>
                    <button className="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
                </form>

                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Titre</th>
                                <th className="text-left px-4 py-3">Année</th>
                                <th className="text-right px-4 py-3">Fichier</th>
                            </tr>
                        </thead>
                        <tbody>
                            {memoires.map((m) => (
                                <tr key={m.id} className="border-t">
                                    <td className="px-4 py-3">{m.titre}</td>
                                    <td className="px-4 py-3">{m.annee}</td>
                                    <td className="px-4 py-3 text-right">
                                        <a href={route('memoires.download', m.id)} className="text-slate-700">Voir PDF</a>
                                    </td>
                                </tr>
                            ))}
                            {memoires.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="3">Aucun mémoire.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
