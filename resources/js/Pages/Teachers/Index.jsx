import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Index({ teachers, search }) {
    const form = useForm({ q: search || '' });

    return (
        <AuthenticatedLayout>
            <Head title="Enseignants" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Enseignants</h1>
                        <p className="text-sm text-slate-600">Liste des enseignants.</p>
                    </div>
                    <div className="flex gap-2">
                        <Link href={route('dashboard')} className="rounded border border-slate-300 px-4 py-2 text-sm">Retour Dashboard</Link>
                        <Link href={route('teachers.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</Link>
                    </div>
                </div>

                <form
                    className="mb-4 flex items-end gap-3"
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.get(route('teachers.index'));
                    }}
                >
                    <div>
                        <label className="block text-sm font-medium">Recherche</label>
                        <input className="mt-1 w-56 rounded border-slate-300" value={form.data.q} onChange={(e) => form.setData('q', e.target.value)} />
                    </div>
                    <button className="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
                </form>

                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Nom</th>
                                <th className="text-left px-4 py-3">Spécialité</th>
                                <th className="text-right px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {teachers.data.map((t) => (
                                <tr key={t.id} className="border-t">
                                    <td className="px-4 py-3">{t.nom} {t.prenom}</td>
                                    <td className="px-4 py-3">{t.specialite}</td>
                                    <td className="px-4 py-3 text-right space-x-2">
                                        <Link href={route('teachers.show', t.id)} className="text-slate-700">Voir</Link>
                                        <Link href={route('teachers.edit', t.id)} className="text-slate-700">Éditer</Link>
                                    </td>
                                </tr>
                            ))}
                            {teachers.data.length === 0 && (
                                <tr className="border-t"><td className="px-4 py-6 text-center text-slate-500" colSpan="3">Aucun enseignant.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
