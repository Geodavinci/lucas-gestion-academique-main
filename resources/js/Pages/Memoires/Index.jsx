import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Index({ memoires, search, annee }) {
    const form = useForm({ q: search || '', annee: annee || '' });

    return (
        <AuthenticatedLayout>
            <Head title="Mémoires" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Mémoires</h1>
                        <p className="text-sm text-slate-600">Tous les mémoires enregistrés.</p>
                    </div>
                    <div className="flex gap-2">
                        <Link href={route('dashboard')} className="rounded border border-slate-300 px-4 py-2 text-sm">Retour Dashboard</Link>
                        <Link href={route('memoires.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</Link>
                    </div>
                </div>

                <form
                    className="mb-4 flex flex-wrap items-end gap-3"
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.get(route('memoires.index'));
                    }}
                >
                    <div>
                        <label className="block text-sm font-medium">Recherche</label>
                        <input className="mt-1 w-56 rounded border-slate-300" value={form.data.q} onChange={(e) => form.setData('q', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Année</label>
                        <input className="mt-1 w-40 rounded border-slate-300" value={form.data.annee} onChange={(e) => form.setData('annee', e.target.value)} />
                    </div>
                    <button className="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
                </form>

                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Titre</th>
                                <th className="text-left px-4 py-3">Étudiant</th>
                                <th className="text-left px-4 py-3">Année</th>
                                <th className="text-right px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {memoires.data.map((m) => (
                                <tr key={m.id} className="border-t">
                                    <td className="px-4 py-3">{m.titre}</td>
                                    <td className="px-4 py-3">{m.student?.nom} {m.student?.prenom}</td>
                                    <td className="px-4 py-3">{m.annee}</td>
                                    <td className="px-4 py-3 text-right">
                                        <a href={route('memoires.download', m.id)} className="text-slate-700">Voir PDF</a>
                                    </td>
                                </tr>
                            ))}
                            {memoires.data.length === 0 && (
                                <tr className="border-t"><td className="px-4 py-6 text-center text-slate-500" colSpan="4">Aucun mémoire.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
